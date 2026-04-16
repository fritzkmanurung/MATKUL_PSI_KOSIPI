<?php

namespace App\Filament\Resources\Pinjamen\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class PinjamenTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('kode_pinjaman')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('user.name')
                    ->label('Anggota')
                    ->sortable()
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('jumlah_pinjaman')
                    ->money('IDR')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('tenor_bulan')
                    ->numeric()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Menunggu' => 'gray',
                        'Disetujui' => 'primary',
                        'Ditolak' => 'danger',
                        'Lunas' => 'success',
                    }),
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
