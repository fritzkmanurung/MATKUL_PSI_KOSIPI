<?php

namespace App\Filament\Member\Resources\SimpananAnggotas\Pages;

use App\Filament\Member\Resources\SimpananAnggotas\SimpananAnggotaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSimpananAnggotas extends ListRecords
{
    protected static string $resource = SimpananAnggotaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
