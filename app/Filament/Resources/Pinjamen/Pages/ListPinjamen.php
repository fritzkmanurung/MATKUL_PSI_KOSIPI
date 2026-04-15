<?php

namespace App\Filament\Resources\Pinjamen\Pages;

use App\Filament\Resources\Pinjamen\PinjamanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPinjamen extends ListRecords
{
    protected static string $resource = PinjamanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
