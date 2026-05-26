<?php

namespace App\Filament\Resources\TagihanPinjamen\Tables;

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

class TagihanPinjamenTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_tagihan')
                    ->searchable(),
                TextColumn::make('pinjaman.kode_pinjaman')
                    ->label('Kode Pinjaman')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('tagihan_ke')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('jatuh_tempo')
                    ->date()
                    ->sortable(),
                MoneyFormatter::rupiah(
                    TextColumn::make('total_tagihan')
                )->sortable(),
                MoneyFormatter::rupiah(
                    TextColumn::make('denda')
                )
                    ->description(fn ($record) => $record->is_telat && $record->status !== 'Lunas' ? "{$record->jumlah_hari_telat} Hari" : null)
                    ->color(fn ($record) => ($record->denda > 0 || $record->is_telat) && $record->status !== 'Lunas' ? 'danger' : null)
                    ->sortable(),
                StatusHelper::applyBadge(
                    TextColumn::make('status')
                ),
            ])
            ->filters([
                //
            ])
            ->headerActions([
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
                            
                            \Modules\Pinjaman\Models\TagihanPinjaman::with('pinjaman.user')->cursor()->each(function ($record) use ($writer) {
                                $writer->addRow([
                                    'Kode Tagihan' => $record->kode_tagihan,
                                    'Peminjam' => ($record->pinjaman && $record->pinjaman->user) ? $record->pinjaman->user->name : '-',
                                    'Tagihan Ke' => $record->tagihan_ke,
                                    'Jatuh Tempo' => $record->jatuh_tempo,
                                    'Nominal Pokok' => $record->nominal_pokok,
                                    'Nominal Bunga' => $record->nominal_bunga,
                                    'Total Tagihan' => $record->total_tagihan,
                                    'Status' => $record->status,
                                ]);
                            });
                            
                            $writer->close();
                        }, 'Rekap_Tagihan_Pinjaman_' . date('Y_m_d_His') . '.' . $data['format']);
                    }),
            ])
            ->actions(\App\Filament\Support\DefaultActionGroup::make('xl'))
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
