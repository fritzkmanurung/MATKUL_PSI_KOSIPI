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

class SimpanansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('user.name')
                    ->label('Anggota')
                    ->sortable()
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('jenis_simpanan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Wajib' => 'warning',
                        'Sukarela' => 'success',
                        'Pokok' => 'info',
                    }),
                \Filament\Tables\Columns\TextColumn::make('nominal_simpanan')
                    ->money('IDR')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('waktu_simpanan')
                    ->date()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Menunggu' => 'gray',
                        'Diterima' => 'success',
                        'Ditolak' => 'danger',
                        default => 'primary',
                    }),
                \Filament\Tables\Columns\ImageColumn::make('bukti_transfer')
                    ->circular(),
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->headerActions([
                \Filament\Tables\Actions\Action::make('export')
                    ->label('Ekspor Laporan')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->form([
                        \Filament\Forms\Components\Select::make('format')
                            ->label('Format File')
                            ->options(['xlsx' => 'Excel (.xlsx)', 'csv' => 'CSV (.csv)'])
                            ->default('xlsx')
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        $records = \Modules\Simpanan\Models\Simpanan::with('user')->get();
                        
                        return response()->streamDownload(function () use ($data, $records) {
                            $writer = \Spatie\SimpleExcel\SimpleExcelWriter::stream('php://output', $data['format']);
                            
                            foreach ($records as $record) {
                                $writer->addRow([
                                    'Kode' => $record->kode_simpanan,
                                    'Anggota' => $record->user ? $record->user->name : '-',
                                    'Jenis' => $record->jenis_simpanan,
                                    'Nominal' => $record->nominal_simpanan,
                                    'Status' => $record->status,
                                    'Tanggal' => $record->created_at->format('Y-m-d H:i')
                                ]);
                            }
                            $writer->close();
                        }, 'Laporan_Simpanan_' . date('Y_m_d_His') . '.' . $data['format']);
                    }),
            ])
            ->bulkActions([
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
