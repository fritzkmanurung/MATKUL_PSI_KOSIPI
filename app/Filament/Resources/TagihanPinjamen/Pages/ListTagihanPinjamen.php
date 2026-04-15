<?php

namespace App\Filament\Resources\TagihanPinjamen\Pages;

use App\Filament\Resources\TagihanPinjamen\TagihanPinjamanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTagihanPinjamen extends ListRecords
{
    protected static string $resource = TagihanPinjamanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
