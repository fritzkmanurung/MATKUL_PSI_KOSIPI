<?php

namespace App\Filament\Member\Resources\TagihanAnggotas\Pages;

use App\Filament\Member\Resources\TagihanAnggotas\TagihanAnggotaResource;
use Filament\Resources\Pages\EditRecord;

class EditTagihanAnggota extends EditRecord
{
    protected static string $resource = TagihanAnggotaResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    /**
     * Override mutateFormDataBeforeSave to automatically set status
     * to "Menunggu Verifikasi" when member uploads bukti bayar.
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (!empty($data['bukti_bayar_transfer'])) {
            $data['status'] = 'Menunggu Verifikasi';
            
            // Re-calculate denda from model logic to ensure persistence
            $this->record->tanggal_bayar = $data['tanggal_bayar'];
            $data['denda'] = $this->record->hitung_denda;
        }

        return $data;
    }
}
