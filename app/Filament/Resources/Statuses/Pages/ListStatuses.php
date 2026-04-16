<?php

namespace App\Filament\Resources\Statuses\Pages;

use App\Filament\Resources\Statuses\StatusResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;

class ListStatuses extends ListRecords
{
    protected static string $resource = StatusResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
