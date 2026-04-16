<?php

namespace App\Filament\Member\Resources\TagihanWajibAnggotas\Pages;

use App\Filament\Member\Resources\TagihanWajibAnggotas\TagihanWajibAnggotaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTagihanWajibAnggota extends EditRecord
{
    protected static string $resource = TagihanWajibAnggotaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
