<?php

namespace App\Filament\Resources\TenggatWaktus\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TenggatWaktusTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('jenis_tagihan')
                    ->label('Jenis Tagihan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Simpanan' => 'info',
                        'Pinjaman' => 'warning',
                        default => 'primary',
                    })
                    ->sortable()
                    ->searchable(),
                TextColumn::make('tanggal_mulai')
                    ->label('Tgl Mulai')
                    ->sortable(),
                TextColumn::make('tanggal_akhir')
                    ->label('Batas Akhir (Tgl)')
                    ->sortable(),
                IconColumn::make('is_aktif')
                    ->label('Status Aktif')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('jenis_tagihan')
                    ->label('Jenis Tagihan')
                    ->options([
                        'Simpanan' => 'Simpanan',
                        'Pinjaman' => 'Pinjaman',
                    ]),
            ])
            ->actions(\App\Filament\Support\DefaultActionGroup::make('sm'))
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
