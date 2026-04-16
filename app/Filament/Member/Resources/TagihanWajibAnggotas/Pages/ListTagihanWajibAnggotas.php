<?php

namespace App\Filament\Member\Resources\TagihanWajibAnggotas\Pages;

use App\Filament\Member\Resources\TagihanWajibAnggotas\TagihanWajibAnggotaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTagihanWajibAnggotas extends ListRecords
{
    protected static string $resource = TagihanWajibAnggotaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
