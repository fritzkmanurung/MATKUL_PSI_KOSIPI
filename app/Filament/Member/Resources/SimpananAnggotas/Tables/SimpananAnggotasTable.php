<?php

namespace App\Filament\Member\Resources\SimpananAnggotas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use App\Filament\Support\MoneyFormatter;
use App\Filament\Support\StatusHelper;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\ViewField;
use Illuminate\Support\Facades\Blade;

class SimpananAnggotasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                StatusHelper::applyBadge(
                    TextColumn::make('jenis_simpanan')
                ),
                MoneyFormatter::rupiah(
                    TextColumn::make('nominal_simpanan')
                )->sortable(),
                MoneyFormatter::rupiah(
                    TextColumn::make('denda')
                )
                    ->description(fn ($record) => $record->is_telat ? "{$record->jumlah_hari_telat} Hari" : null)
                    ->color(fn ($record) => $record->denda > 0 || $record->is_telat ? 'danger' : null)
                    ->sortable(),
                StatusHelper::applyBadge(
                    TextColumn::make('status')
                ),
                \Filament\Tables\Columns\ImageColumn::make('bukti_transfer')
                    ->label('Bukti')
                    ->circular(),
                TextColumn::make('waktu_simpanan')
                    ->date('d M Y')
                    ->label('Tanggal Bayar')
                    ->placeholder('Belum')
                    ->description(fn ($record) => $record->is_telat ? '⚠️ Telat Membayar' : null)
                    ->color(fn ($record) => $record->is_telat ? 'danger' : null)
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                \Filament\Actions\ActionGroup::make([
                    \Filament\Actions\ViewAction::make()
                        ->modalWidth('md')
                        ->modalHeading(fn ($record) => Blade::render('<x-filament.support.modal-header-with-status title="Detail Simpanan" :status="$status" />', ['status' => $record->status ?? 'Menunggu'])),
                    \Filament\Actions\Action::make('bayar_tagihan')
                        ->label('Bayar Tagihan')
                        ->icon('heroicon-o-credit-card')
                        ->color('primary')
                        ->visible(fn ($record) => $record->status === 'Belum Dibayar')
                        ->form([
                            \Filament\Forms\Components\FileUpload::make('bukti_transfer')
                                ->label('Unggah Bukti Transfer')
                                ->image()
                                ->directory('bukti-simpanan')
                                ->required()
                                ->maxSize(2048),
                            \Filament\Forms\Components\DatePicker::make('waktu_simpanan')
                                ->label('Tanggal Bayar')
                                ->default(now())
                                ->required()
                                ->live(),
                            ViewField::make('info_denda')
                                ->label('')
                                ->view('filament.member.payment-summary')
                                ->viewData(function ($record, $get) {
                                    $record->waktu_simpanan = $get('waktu_simpanan');
                                    return [
                                        'pokok' => $record->nominal_simpanan,
                                        'denda' => $record->hitung_denda,
                                        'hariTelat' => $record->jumlah_hari_telat,
                                    ];
                                }),
                        ])
                        ->action(function ($record, array $data) {
                            // Hitung denda berdasarkan tanggal yang diinput user
                            $record->waktu_simpanan = $data['waktu_simpanan'];
                            $dendaNominal = $record->hitung_denda;

                            $record->update([
                                'bukti_transfer' => $data['bukti_transfer'],
                                'waktu_simpanan' => $data['waktu_simpanan'],
                                'denda' => $dendaNominal,
                                'status' => 'Menunggu',
                            ]);
                            \Filament\Notifications\Notification::make()
                                ->title('Berhasil')
                                ->body('Bukti transfer berhasil diunggah. Total bayar (termasuk denda jika ada) sedangan diverifikasi.')
                                ->success()
                                ->send();
                        }),
                    \Filament\Actions\EditAction::make()
                        ->label(fn ($record) => $record->status === 'Revisi' ? 'Perbaiki' : 'Ubah')
                        ->modalWidth('md')
                        ->modalHeading(fn ($record) => Blade::render('<x-filament.support.modal-header-with-status title="Ubah Simpanan" :status="$status" />', ['status' => $record->status ?? 'Menunggu']))
                        ->visible(fn ($record) => in_array($record->status, ['Menunggu', 'Revisi']))
                        ->mutateFormDataUsing(function (array $data): array {
                            $data['status'] = 'Menunggu';
                            return $data;
                        }),
                    \Filament\Actions\DeleteAction::make()
                        ->authorize(fn ($record) => $record->user_id === auth()->id())
                        ->visible(fn ($record) => $record->status === 'Menunggu'),
                ]),
            ]);
    }
}
