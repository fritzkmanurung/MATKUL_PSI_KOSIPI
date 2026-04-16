<?php

namespace App\Filament\Member\Resources\PenarikanAnggotas\Schemas;

use Filament\Forms\Components;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;

class PenarikanAnggotaForm
{
    public static function configure(Schema $schema): Schema
    {
        $sukarelaAmount = \Modules\Simpanan\Models\TotalSimpanan::where('user_id', auth()->id())->first()?->total_simpanan_sukarela ?? 0;

        return $schema
            ->components([
                Grid::make(['default' => 1])
                    ->schema([
                        Forms\Components\Placeholder::make('sisa_saldo_sukarela')
                            ->label('Sisa Saldo Sukarela')
                            ->content('Rp ' . number_format($sukarelaAmount, 0, ',', '.')),
                        Forms\Components\TextInput::make('nominal_penarikan')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->maxValue($sukarelaAmount)
                            ->label('Uang yang Ingin Ditarik (Pencairan)'),
                    ]),
            ]);
    }
}
