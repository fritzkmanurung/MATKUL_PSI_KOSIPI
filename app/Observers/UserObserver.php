<?php

namespace App\Observers;

use App\Models\User;
use Modules\Simpanan\Models\Simpanan;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // Hanya generate Simpanan Pokok jika belum ada
        $exists = Simpanan::where('user_id', $user->id)->where('jenis_simpanan', 'Pokok')->exists();
        
        if (!$exists) {
            $besaranPokok = \Modules\Simpanan\Models\BesaranSimpanan::getAktif('Pokok');
            $nominalSimpananPokok = $besaranPokok ? $besaranPokok->nominal : config('koperasi.simpanan.default_pokok');

            Simpanan::create([
                'user_id' => $user->id,
                'nominal_simpanan' => $nominalSimpananPokok,
                'jenis_simpanan' => 'Pokok',
                'status' => 'Menunggu',
                'waktu_simpanan' => now()->toDateString(),
                'periode' => now()->format('Y-m'),
                'bulan' => now()->format('m'),
                'jenis_pembayaran' => 'Transfer',
            ]);
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }
}
