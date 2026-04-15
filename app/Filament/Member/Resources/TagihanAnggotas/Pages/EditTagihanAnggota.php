<?php

namespace App\Filament\Member\Resources\TagihanAnggotas\Pages;

use App\Filament\Member\Resources\TagihanAnggotas\TagihanAnggotaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditTagihanAnggota extends EditRecord
{
    protected static string $resource = TagihanAnggotaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
