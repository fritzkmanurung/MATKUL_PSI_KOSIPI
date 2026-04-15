<?php

namespace App\Filament\Resources\TagihanPinjamen\Pages;

use App\Filament\Resources\TagihanPinjamen\TagihanPinjamanResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTagihanPinjaman extends EditRecord
{
    protected static string $resource = TagihanPinjamanResource::class;

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
