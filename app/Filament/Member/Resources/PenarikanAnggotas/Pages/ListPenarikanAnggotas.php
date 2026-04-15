<?php

namespace App\Filament\Member\Resources\PenarikanAnggotas\Pages;

use App\Filament\Member\Resources\PenarikanAnggotas\PenarikanAnggotaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPenarikanAnggotas extends ListRecords
{
    protected static string $resource = PenarikanAnggotaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
