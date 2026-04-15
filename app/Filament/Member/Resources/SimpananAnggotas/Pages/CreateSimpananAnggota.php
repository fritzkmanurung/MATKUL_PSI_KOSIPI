<?php

namespace App\Filament\Member\Resources\SimpananAnggotas\Pages;

use App\Filament\Member\Resources\SimpananAnggotas\SimpananAnggotaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSimpananAnggota extends CreateRecord
{
    protected static string $resource = SimpananAnggotaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['status'] = 'Menunggu';
        return $data;
    }
}
