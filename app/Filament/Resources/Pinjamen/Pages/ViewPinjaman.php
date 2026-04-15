<?php

namespace App\Filament\Resources\Pinjamen\Pages;

use App\Filament\Resources\Pinjamen\PinjamanResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPinjaman extends ViewRecord
{
    protected static string $resource = PinjamanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
