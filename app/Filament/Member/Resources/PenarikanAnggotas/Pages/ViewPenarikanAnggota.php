<?php

namespace App\Filament\Member\Resources\PenarikanAnggotas\Pages;

use App\Filament\Member\Resources\PenarikanAnggotas\PenarikanAnggotaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPenarikanAnggota extends ViewRecord
{
    protected static string $resource = PenarikanAnggotaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
