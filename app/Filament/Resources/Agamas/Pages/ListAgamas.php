<?php

namespace App\Filament\Resources\Agamas\Pages;

use App\Filament\Resources\Agamas\AgamaResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;

class ListAgamas extends ListRecords
{
    protected static string $resource = AgamaResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
