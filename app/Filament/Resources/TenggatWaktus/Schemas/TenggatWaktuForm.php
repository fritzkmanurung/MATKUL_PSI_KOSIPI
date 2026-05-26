<?php

namespace App\Filament\Resources\TenggatWaktus\Schemas;

use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Placeholder;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class TenggatWaktuForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('jenis_tagihan')
                    ->label('Jenis Tagihan')
                    ->options([
                        'Simpanan' => 'Simpanan Wajib',
                        'Pinjaman' => 'Tagihan Pinjaman',
                    ])
                    ->required()
                    ->default('Simpanan'),
                Grid::make(2)->schema([
                    TextInput::make('tanggal_mulai')
                        ->label('Tanggal Mulai')
                        ->numeric()
                        ->default(1)
                        ->minValue(1)
                        ->maxValue(31)
                        ->required(),
                    TextInput::make('tanggal_akhir')
                        ->label('Tanggal Akhir')
                        ->numeric()
                        ->default(7)
                        ->minValue(1)
                        ->maxValue(31)
                        ->required(),
                ]),
                Toggle::make('is_aktif')
                    ->label('Aktifkan Aturan Ini')
                    ->default(true)
                    ->required()
                    ->hiddenOn('view'),
                Placeholder::make('status_label')
                    ->label('Status Aturan')
                    ->content(fn ($record) => new HtmlString(Blade::render('<x-koperasi.status-badge :status="$status" />', [
                        'status' => $record?->is_aktif ? 'Aktif' : 'Non-aktif'
                    ])))
                    ->visibleOn('view'),
            ])->columns(1);
    }
}

