<?php

namespace App\Filament\Resources\Instansis\Pages;

use App\Filament\Resources\Instansis\InstansiResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;

class ListInstansis extends ListRecords
{
    protected static string $resource = InstansiResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
