<?php

namespace App\Filament\Resources\TagihanWajibs\Pages;

use App\Filament\Resources\TagihanWajibs\TagihanWajibResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTagihanWajib extends ViewRecord
{
    protected static string $resource = TagihanWajibResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
