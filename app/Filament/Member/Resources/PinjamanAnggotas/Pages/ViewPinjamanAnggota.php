<?php

namespace App\Filament\Member\Resources\PinjamanAnggotas\Pages;

use App\Filament\Member\Resources\PinjamanAnggotas\PinjamanAnggotaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPinjamanAnggota extends ViewRecord
{
    protected static string $resource = PinjamanAnggotaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
