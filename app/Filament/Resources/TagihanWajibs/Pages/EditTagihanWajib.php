<?php

namespace App\Filament\Resources\TagihanWajibs\Pages;

use App\Filament\Resources\TagihanWajibs\TagihanWajibResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTagihanWajib extends EditRecord
{
    protected static string $resource = TagihanWajibResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
