<?php

namespace App\Filament\Resources\TenggatWaktus\Pages;

use App\Filament\Resources\TenggatWaktus\TenggatWaktuResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTenggatWaktus extends ListRecords
{
    protected static string $resource = TenggatWaktuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
