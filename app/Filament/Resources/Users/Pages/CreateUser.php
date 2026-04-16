<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        $simpananPokok = $data['simpanan_pokok'] ?? 0;
        unset($data['simpanan_pokok']);

        $user = parent::handleRecordCreation($data);

        // Jika simpanan pokok diisi, buat record Simpanan Pokok otomatis
        if ($simpananPokok > 0) {
            \Modules\Simpanan\Models\Simpanan::create([
                'user_id' => $user->id,
                'jenis_simpanan' => 'Pokok',
                'nominal_simpanan' => $simpananPokok,
                'waktu_simpanan' => now()->toDateString(),
                'periode' => now()->format('Y'),
                'bulan' => now()->format('m'),
                'jenis_pembayaran' => 'Transfer', // Default bayar
                'status' => 'Diterima',
            ]);
        }

        return $user;
    }
}
