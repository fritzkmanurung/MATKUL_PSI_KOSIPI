<?php

namespace App\Filament\Resources\TotalSimpanans\Pages;

use App\Filament\Resources\TotalSimpanans\TotalSimpananResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTotalSimpanan extends EditRecord
{
    protected static string $resource = TotalSimpananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
