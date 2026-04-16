<?php

namespace App\Filament\Member\Resources\PinjamanAnggotas\Schemas;

use Filament\Forms\Components;
use Filament\Forms;
use Filament\Schemas\Schema;

class PinjamanAnggotaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Grid::make(['default' => 1, 'md' => 2])
                    ->schema([
                        Forms\Components\Section::make('Kalkulator Kredit')
                            ->schema([
                                Forms\Components\TextInput::make('jumlah_pinjaman')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->label('Plafon Pinjaman Tujuan'),
                                Forms\Components\TextInput::make('tenor_bulan')
                                    ->required()
                                    ->numeric()
                                    ->suffix('Bulan')
                                    ->label('Lama Angsuran'),
                            ])->columnSpan(1),
                        Forms\Components\Section::make('Dasar Pengajuan')
                            ->schema([
                                Forms\Components\Textarea::make('alasan')
                                    ->required()
                                    ->label('Alasan/Tujuan Meminjam')
                                    ->rows(4),
                            ])->columnSpan(1),
                    ]),
            ]);
    }
}
