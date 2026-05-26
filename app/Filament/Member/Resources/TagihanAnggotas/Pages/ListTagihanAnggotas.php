<?php

namespace App\Filament\Member\Resources\TagihanAnggotas\Pages;

use App\Filament\Member\Resources\TagihanAnggotas\TagihanAnggotaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTagihanAnggotas extends ListRecords
{
    protected static string $resource = TagihanAnggotaResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
