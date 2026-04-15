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
