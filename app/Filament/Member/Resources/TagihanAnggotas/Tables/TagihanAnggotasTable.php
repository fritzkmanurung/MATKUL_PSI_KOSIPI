<?php

namespace App\Filament\Member\Resources\TagihanAnggotas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use App\Filament\Support\MoneyFormatter;
use App\Filament\Support\StatusHelper;
use Filament\Tables\Columns\TextColumn;

class TagihanAnggotasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_tagihan')
                    ->label('Nomor Tagihan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tagihan_ke')
                    ->label('Ke')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('jatuh_tempo')
                    ->label('Jatuh Tempo')
                    ->date('d M Y')
                    ->description(fn ($record) => $record->is_telat && $record->status !== 'Lunas' ? '⚠️ Telat' : null)
                    ->color(fn ($record) => $record->is_telat && $record->status !== 'Lunas' ? 'danger' : null)
                    ->sortable(),
                MoneyFormatter::rupiah(
                    TextColumn::make('total_tagihan')
                )->label('Cicilan'),
                MoneyFormatter::rupiah(
                    TextColumn::make('denda')
                )
                    ->label('Denda')
                    ->description(fn ($record) => $record->is_telat && $record->status !== 'Lunas' ? "{$record->jumlah_hari_telat} Hari" : null)
                    ->color(fn ($record) => ($record->denda > 0 || $record->is_telat) && $record->status !== 'Lunas' ? 'danger' : null),
                StatusHelper::applyBadge(
                    TextColumn::make('status')
                ),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Belum Dibayar' => 'Belum Dibayar',
                        'Menunggu Verifikasi' => 'Menunggu Verifikasi',
                        'Lunas' => 'Lunas',
                        'Ditolak' => 'Ditolak',
                    ]),
            ])
            ->actions([
                \Filament\Tables\Actions\EditAction::make()
                    ->label('Bayar')
                    ->icon('heroicon-o-credit-card')
                    ->visible(fn ($record) => in_array($record->status, ['Belum Dibayar', 'Ditolak'])),
                \Filament\Tables\Actions\ViewAction::make(),
            ]);
    }
}
