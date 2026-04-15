<?php

namespace App\Filament\Resources\Penarikans\Pages;

use App\Filament\Resources\Penarikans\PenarikanResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPenarikan extends ViewRecord
{
    protected static string $resource = PenarikanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
