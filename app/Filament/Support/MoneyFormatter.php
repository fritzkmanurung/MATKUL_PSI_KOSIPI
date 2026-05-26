<?php

namespace App\Filament\Support;

use Filament\Tables\Columns\TextColumn;

class MoneyFormatter
{
    public static function rupiah(\Filament\Tables\Columns\TextColumn|\Filament\Infolists\Components\TextEntry $component): \Filament\Tables\Columns\TextColumn|\Filament\Infolists\Components\TextEntry
    {
        return $component
            ->prefix('Rp ')
            ->numeric(0, ',', '.');
    }

    public static function format($value): string
    {
        return 'Rp ' . number_format((float)$value, 0, ',', '.');
    }
}
