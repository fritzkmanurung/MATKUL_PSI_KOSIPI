<?php

namespace App\Filament\Member\Resources\PinjamanAnggotas\Pages;

use App\Filament\Member\Resources\PinjamanAnggotas\PinjamanAnggotaResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePinjamanAnggota extends CreateRecord
{
    protected static string $resource = PinjamanAnggotaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['status'] = 'Menunggu';
        return $data;
    }
}
