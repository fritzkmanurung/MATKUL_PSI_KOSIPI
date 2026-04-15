<?php

namespace App\Filament\Member\Resources\PinjamanAnggotas\Pages;

use App\Filament\Member\Resources\PinjamanAnggotas\PinjamanAnggotaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPinjamanAnggota extends EditRecord
{
    protected static string $resource = PinjamanAnggotaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
