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

        // Pilar 4: Cek pinjaman aktif
        if (\Modules\Pinjaman\Models\Pinjaman::hasAktifPinjaman($user->id)) {
            \Filament\Notifications\Notification::make()
                ->title('Pengajuan Ditolak')
                ->body('Anda masih memiliki pinjaman aktif yang belum lunas.')
                ->danger()
                ->send();
            $this->halt();
        }

        // Pilar 3: Cek tunggakan
        $tunggakan = \Modules\Pinjaman\Models\Pinjaman::hasTunggakan($user->id);
        if ($tunggakan['ada_tunggakan']) {
            \Filament\Notifications\Notification::make()
                ->title('Pengajuan Ditolak')
                ->body('Anda masih memiliki tunggakan simpanan wajib atau denda yang belum dilunasi. Silakan lunasi terlebih dahulu.')
                ->danger()
                ->send();
            $this->halt();
        }

        return $data;
    }
}
