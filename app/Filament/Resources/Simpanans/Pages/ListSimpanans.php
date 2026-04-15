<?php

namespace App\Filament\Resources\Simpanans\Pages;

use App\Filament\Resources\Simpanans\SimpananResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSimpanans extends ListRecords
{
    protected static string $resource = SimpananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
