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
use App\Filament\Support\MoneyFormatter;
use App\Filament\Support\StatusHelper;
use Filament\Tables\Columns\TextColumn;

class PinjamenTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_pinjaman')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Anggota')
                    ->sortable()
                    ->searchable(),
                MoneyFormatter::rupiah(
                    TextColumn::make('jumlah_pinjaman')
                )->sortable(),
                TextColumn::make('tenor_bulan')
                    ->numeric()
                    ->sortable(),
                StatusHelper::applyBadge(
                    TextColumn::make('status')
                ),
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions(\App\Filament\Support\DefaultActionGroup::make('xl'))
            ->toolbarActions([]);
    }
}
