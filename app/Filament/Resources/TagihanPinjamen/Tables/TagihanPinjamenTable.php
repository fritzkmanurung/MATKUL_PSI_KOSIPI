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

class TagihanPinjamenTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('kode_tagihan')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('pinjaman.kode_pinjaman')
                    ->label('Kode Pinjaman')
                    ->sortable()
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('tagihan_ke')
                    ->numeric()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('jatuh_tempo')
                    ->date()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('total_tagihan')
                    ->money('IDR')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Belum Dibayar' => 'warning',
                        'Menunggu Verifikasi' => 'gray',
                        'Lunas' => 'success',
                        'Ditolak' => 'danger',
                    }),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->headerActions([
                \Filament\Tables\Actions\Action::make('export')
                    ->label('Ekspor Rekap Tagihan')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->form([
                        \Filament\Forms\Components\Select::make('format')
                            ->label('Format File')
                            ->options(['xlsx' => 'Excel (.xlsx)', 'csv' => 'CSV (.csv)'])
                            ->default('xlsx')
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        $records = \Modules\Pinjaman\Models\TagihanPinjaman::with('pinjaman.user')->get();
                        
                        return response()->streamDownload(function () use ($data, $records) {
                            $writer = \Spatie\SimpleExcel\SimpleExcelWriter::stream('php://output', $data['format']);
                            
                            foreach ($records as $record) {
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
                            }
                            $writer->close();
                        }, 'Rekap_Tagihan_Pinjaman_' . date('Y_m_d_His') . '.' . $data['format']);
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
