<?php

namespace App\Filament\Member\Resources\SimpananAnggotas\Pages;

use App\Filament\Member\Resources\SimpananAnggotas\SimpananAnggotaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSimpananAnggota extends ViewRecord
{
    protected static string $resource = SimpananAnggotaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
