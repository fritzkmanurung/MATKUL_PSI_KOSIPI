<?php

namespace App\Filament\Resources\UnitKerjas\Pages;

use App\Filament\Resources\UnitKerjas\UnitKerjaResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;

class ListUnitKerjas extends ListRecords
{
    protected static string $resource = UnitKerjaResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
