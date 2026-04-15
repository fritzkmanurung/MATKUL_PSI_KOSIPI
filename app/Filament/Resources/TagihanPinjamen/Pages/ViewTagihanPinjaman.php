<?php

namespace App\Filament\Resources\TagihanPinjamen\Pages;

use App\Filament\Resources\TagihanPinjamen\TagihanPinjamanResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTagihanPinjaman extends ViewRecord
{
    protected static string $resource = TagihanPinjamanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
