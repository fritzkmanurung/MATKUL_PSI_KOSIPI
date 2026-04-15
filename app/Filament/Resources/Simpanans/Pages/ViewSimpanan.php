<?php

namespace App\Filament\Resources\Simpanans\Pages;

use App\Filament\Resources\Simpanans\SimpananResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSimpanan extends ViewRecord
{
    protected static string $resource = SimpananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
