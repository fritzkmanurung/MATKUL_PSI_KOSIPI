<?php

namespace App\Filament\Member\Resources\SimpananAnggotas\Schemas;

use Filament\Forms\Components;
use Filament\Forms;
use Filament\Schemas\Schema;

class SimpananAnggotaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Grid::make(['default' => 1, 'md' => 2])
                    ->schema([
                        Forms\Components\Select::make('jenis_simpanan')
                            ->options([
                                'Pokok' => 'Simpanan Pokok (Uang Pangkal)',
                                'Wajib' => 'Simpanan Wajib (Bulanan)',
                                'Sukarela' => 'Simpanan Sukarela',
                            ])
                            ->required()
                            ->label('Pilih Jenis Setoran')
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('nominal_simpanan')
                            ->numeric()
                            ->required()
                            ->prefix('Rp')
                            ->label('Nominal Setoran')
                            ->columnSpan(1),
                        Forms\Components\FileUpload::make('bukti_transfer')
                            ->image()
                            ->required()
                            ->label('Unggah Bukti Transfer')
                            ->directory('bukti-simpanan')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
