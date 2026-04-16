<?php

namespace App\Filament\Member\Resources\PinjamanAnggotas\Pages;

use App\Filament\Member\Resources\PinjamanAnggotas\PinjamanAnggotaResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePinjamanAnggota extends CreateRecord
{
    protected static string $resource = PinjamanAnggotaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = auth()->user();
        
        $data['user_id'] = $user->id;
        $data['status'] = 'Menunggu';
        $data['kode_pinjaman'] = 'PNJ-' . date('Ymd') . '-' . rand(1000, 9999);
        $data['bunga_persen'] = 0;
        
        // Auto-fill dari profil Member
        $data['pekerjaan'] = $user->pekerjaan ?? '-';
        $data['status_pegawai'] = $user->status_pegawai ?? '-';
        $data['status_perkawinan'] = $user->status_perkawinan ?? '-';
        $data['masa_kontrak'] = $user->masa_kontrak ?? 0;
        $data['nama_suami_istri'] = $user->nama_suami_istri ?? '-';
        
        return $data;
    }
}
