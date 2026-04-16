<?php

namespace App\Filament\Member\Resources\PenarikanAnggotas\Pages;

use App\Filament\Member\Resources\PenarikanAnggotas\PenarikanAnggotaResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePenarikanAnggota extends CreateRecord
{
    protected static string $resource = PenarikanAnggotaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['status'] = 'Menunggu';
        $data['tanggal_penarikan'] = now()->toDateString();
        return $data;
    }
}
