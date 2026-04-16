<?php

namespace App\Filament\Resources\TagihanWajibs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class TagihanWajibsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_tagihan')->label('Kode Tagihan')->searchable()->sortable(),
                TextColumn::make('user.name')->label('Anggota')->searchable()->sortable(),
                TextColumn::make('periode')->label('Periode')->sortable(),
                TextColumn::make('nominal_tagihan')->label('Nominal')->money('IDR')->sortable(),
                TextColumn::make('status')->label('Status')->badge()
                    ->color(fn (string $state) => match ($state) {
                        'Lunas' => 'success',
                        'Menunggu Verifikasi' => 'warning',
                        default => 'danger',
                    }),
                TextColumn::make('tanggal_bayar')->label('Tgl Bayar')->date('d/m/Y'),
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
                ]),
            ]);
    }
}
