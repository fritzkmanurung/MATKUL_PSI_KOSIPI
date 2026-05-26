<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('member.foto_profil')
                    ->label('Foto')
                    ->circular(),
                TextColumn::make('member.nba')
                    ->label('NBA')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('member.nip')
                    ->label('NIP')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('member.no_hp')
                    ->label('No. HP')
                    ->searchable(),
                TextColumn::make('member.unitKerja.nama')
                    ->label('Unit Kerja')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('member.status.nama')
                    ->label('Status')
                    ->badge()
                    ->color('warning')
                    ->sortable(),
                TextColumn::make('member.tanggal_bergabung')
                    ->label('Tgl Bergabung')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
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
