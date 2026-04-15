<?php

namespace App\Filament\Member\Resources\PenarikanAnggotas\Pages;

use App\Filament\Member\Resources\PenarikanAnggotas\PenarikanAnggotaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPenarikanAnggota extends EditRecord
{
    protected static string $resource = PenarikanAnggotaResource::class;

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
