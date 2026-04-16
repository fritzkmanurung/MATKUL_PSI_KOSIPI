<?php

namespace App\Filament\Member\Resources\PenarikanAnggotas\Schemas;

use Filament\Forms\Components;
use Filament\Forms;
use Filament\Schemas\Schema;

class PenarikanAnggotaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Grid::make(['default' => 1])
                    ->schema([
                        Forms\Components\Select::make('simpanan_id')
                            ->relationship('simpanan', 'kode_simpanan')
                            ->label('Referensi Simpanan')
                            ->required(),
                        Forms\Components\TextInput::make('nominal_penarikan')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->label('Uang yang Ingin Ditarik (Pencairan)'),
                        Forms\Components\Textarea::make('alasan')
                            ->required()
                            ->label('Alasan Pencairan'),
                    ]),
            ]);
    }
}
