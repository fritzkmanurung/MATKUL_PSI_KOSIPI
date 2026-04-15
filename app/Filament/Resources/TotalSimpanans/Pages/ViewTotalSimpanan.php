<?php

namespace App\Filament\Resources\TotalSimpanans\Pages;

use App\Filament\Resources\TotalSimpanans\TotalSimpananResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTotalSimpanan extends ViewRecord
{
    protected static string $resource = TotalSimpananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
