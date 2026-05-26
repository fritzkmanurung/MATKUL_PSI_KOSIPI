<?php

namespace App\Filament\Resources\Bungas\Schemas;

use Filament\Forms\Components;
use Filament\Forms;
use Filament\Schemas\Schema;

class BungaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('nilai_persen')
                    ->required()
                    ->numeric()
                    ->suffix('%')
                    ->maxValue(100),
                Forms\Components\Textarea::make('keterangan')
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_aktif')
                    ->label('Bunga Aktif (Digunakan untuk Pinjaman Baru)')
                    ->helperText('Hanya 1 bunga yang boleh aktif. Mengaktifkan bunga ini akan menonaktifkan bunga lainnya.')
                    ->columnSpanFull(),
            ]);
    }
}
