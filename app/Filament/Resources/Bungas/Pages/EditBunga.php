<?php

namespace App\Filament\Resources\Bungas\Pages;

use App\Filament\Resources\Bungas\BungaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBunga extends EditRecord
{
    protected static string $resource = BungaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
