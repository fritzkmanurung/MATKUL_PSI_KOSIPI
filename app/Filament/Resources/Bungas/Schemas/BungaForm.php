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
            ]);
    }
}
