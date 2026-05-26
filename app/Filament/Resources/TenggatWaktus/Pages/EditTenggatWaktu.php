<?php

namespace App\Filament\Resources\TenggatWaktus\Pages;

use App\Filament\Resources\TenggatWaktus\TenggatWaktuResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTenggatWaktu extends EditRecord
{
    protected static string $resource = TenggatWaktuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
