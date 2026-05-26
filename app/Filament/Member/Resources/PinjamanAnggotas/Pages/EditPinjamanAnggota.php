<?php

namespace App\Filament\Member\Resources\PinjamanAnggotas\Pages;

use App\Filament\Member\Resources\PinjamanAnggotas\PinjamanAnggotaResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPinjamanAnggota extends EditRecord
{
    protected static string $resource = PinjamanAnggotaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
        ];
    }

    /**
     * When member re-submits or uploads documents, reset status appropriately.
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $record = $this->record;

        // If member is uploading documents for the first time or re-uploading
        if (in_array($record->status, ['Menunggu Dokumen', 'Ditolak Dokumen'])) {
            // Only change status if both documents are provided
            if (!empty($data['dokumen_persetujuan_1']) && !empty($data['dokumen_persetujuan_2'])) {
                $data['status'] = 'Menunggu Verifikasi Dokumen';
            }
        }

        // If rejected at initial stage, reset to Menunggu
        if ($record->status === 'Ditolak') {
            $data['status'] = 'Menunggu';
            $data['catatan_penolakan'] = null;
        }

        return $data;
    }
}
