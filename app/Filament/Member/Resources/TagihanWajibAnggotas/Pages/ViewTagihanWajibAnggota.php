<?php

namespace App\Filament\Member\Resources\TagihanWajibAnggotas\Pages;

use App\Filament\Member\Resources\TagihanWajibAnggotas\TagihanWajibAnggotaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTagihanWajibAnggota extends ViewRecord
{
    protected static string $resource = TagihanWajibAnggotaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
