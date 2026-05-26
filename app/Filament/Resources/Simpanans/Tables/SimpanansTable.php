<?php

namespace App\Filament\Resources\Simpanans\Tables;

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

class SimpanansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Anggota')
                    ->sortable()
                    ->searchable(),
                StatusHelper::applyBadge(
                    TextColumn::make('jenis_simpanan')
                ),
                MoneyFormatter::rupiah(
                    TextColumn::make('nominal_simpanan')
                )->sortable(),
                MoneyFormatter::rupiah(
                    TextColumn::make('denda')
                )
                    ->description(fn ($record) => $record->is_telat && $record->status !== 'Diterima' ? "{$record->jumlah_hari_telat} Hari" : null)
                    ->color(fn ($record) => ($record->denda > 0 || $record->is_telat) && $record->status !== 'Diterima' ? 'danger' : null)
                    ->sortable(),
                TextColumn::make('waktu_simpanan')
                    ->date('d M Y')
                    ->placeholder('-')
                    ->description(fn ($record) => $record->is_telat ? '⚠️ Telat Membayar' : null)
                    ->color(fn ($record) => $record->is_telat ? 'danger' : null)
                    ->sortable(),
                StatusHelper::applyBadge(
                    TextColumn::make('status')
                ),
                \Filament\Tables\Columns\ImageColumn::make('bukti_transfer')
                    ->circular(),
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('jenis_simpanan')
                    ->label('Jenis Simpanan')
                    ->options([
                        'Pokok' => 'Pokok',
                        'Wajib' => 'Wajib',
                        'Sukarela' => 'Sukarela',
                    ]),
                \Filament\Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'Belum Dibayar' => 'Belum Dibayar',
                        'Menunggu' => 'Menunggu',
                        'Diterima' => 'Diterima',
                        'Revisi' => 'Revisi',
                        'Ditolak' => 'Ditolak',
                    ]),
                \Filament\Tables\Filters\SelectFilter::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->label('Anggota'),
            ])
            ->headerActions([
                \Filament\Actions\Action::make('generate_tagihan')
                    ->label('Buat Tagihan')
                    ->icon('heroicon-o-document-plus')
                    ->color('warning')
                    ->form([
                        \Filament\Forms\Components\TextInput::make('periode')
                            ->label('Periode (Tahun)')
                            ->default(date('Y'))
                            ->required(),
                        \Filament\Forms\Components\Select::make('bulan')
                            ->options([
                                '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                                '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                                '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                            ])
                            ->default(date('m'))
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        $nominal = \Modules\Simpanan\Models\BesaranSimpanan::getAktif('Wajib')?->nominal ?? 0;
                        if ($nominal <= 0) {
                            \Filament\Notifications\Notification::make()
                                ->title('Gagal')
                                ->body('Besaran Simpanan Wajib aktif belum diatur atau nominalnya 0.')
                                ->danger()
                                ->send();
                            return;
                        }

                        $count = 0;
                        \Illuminate\Support\Facades\DB::transaction(function () use ($data, $nominal, &$count) {
                            \App\Models\User::role('anggota')->chunk(100, function ($members) use ($data, $nominal, &$count) {
                                foreach ($members as $member) {
                                    $exists = \Modules\Simpanan\Models\Simpanan::where('user_id', $member->id)
                                        ->where('jenis_simpanan', 'Wajib')
                                        ->where('periode', $data['periode'])
                                        ->where('bulan', $data['bulan'])
                                        ->lockForUpdate()
                                        ->exists();

                                    if (! $exists) {
                                        \Modules\Simpanan\Models\Simpanan::create([
                                            'user_id' => $member->id,
                                            'jenis_simpanan' => 'Wajib',
                                            'nominal_simpanan' => $nominal,
                                            'periode' => $data['periode'],
                                            'bulan' => $data['bulan'],
                                            'status' => 'Belum Dibayar',
                                        ]);
                                        $count++;
                                    }
                                }
                            });
                        });

                        \Filament\Notifications\Notification::make()
                            ->title('Berhasil')
                            ->body("Berhasil meng-generate $count tagihan simpanan wajib.")
                            ->success()
                            ->send();
                    }),
                \Filament\Actions\Action::make('export')
                    ->label('Ekspor')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->form([
                        \Filament\Forms\Components\Select::make('format')
                            ->label('Format File')
                            ->options(['xlsx' => 'Excel (.xlsx)', 'csv' => 'CSV (.csv)'])
                            ->default('xlsx')
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        return response()->streamDownload(function () use ($data) {
                            $writer = \Spatie\SimpleExcel\SimpleExcelWriter::stream('php://output', $data['format']);
                            
                            \Modules\Simpanan\Models\Simpanan::with('user')->cursor()->each(function ($record) use ($writer) {
                                $writer->addRow([
                                    'Kode' => $record->kode_simpanan ?? '-',
                                    'Anggota' => $record->user ? $record->user->name : '-',
                                    'Jenis' => $record->jenis_simpanan,
                                    'Nominal' => $record->nominal_simpanan,
                                    'Status' => $record->status,
                                    'Tanggal' => $record->created_at->format('Y-m-d H:i')
                                ]);
                            });
                            
                            $writer->close();
                        }, 'Laporan_Simpanan_' . date('Y_m_d_His') . '.' . $data['format']);
                    }),
            ])
            ->actions(\App\Filament\Support\DefaultActionGroup::make('xl'))
            ->toolbarActions([]);
    }
}
