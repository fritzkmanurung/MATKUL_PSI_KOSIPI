<?php

namespace App\Filament\Resources\Bungas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;

class BungasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('nilai_persen')
                    ->numeric()
                    ->suffix('%')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('keterangan')
                    ->searchable(),
                \Filament\Tables\Columns\IconColumn::make('is_aktif')
                    ->label('Aktif')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions(\App\Filament\Support\DefaultActionGroup::make('md'))
            ->toolbarActions([]);
    }
}
