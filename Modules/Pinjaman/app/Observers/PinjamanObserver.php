<?php

namespace Modules\Pinjaman\Observers;

use Modules\Pinjaman\Models\Pinjaman;
use Modules\Pinjaman\Models\TagihanPinjaman;
use Illuminate\Support\Carbon;

class PinjamanObserver
{
    /**
     * Listen to the Pinjaman "updated" event.
     */
    public function updated(Pinjaman $pinjaman): void
    {
        // Hanya eksekusi ketika status berubah dari selain 'Disetujui' menjadi 'Disetujui'
        if ($pinjaman->isDirty('status') && $pinjaman->status === 'Disetujui') {
            $this->generateTagihan($pinjaman);
        }
    }

    /**
     * Logic Pintar (Amortisasi Flat) untuk mengenerate otomatis baris tagihan cicilan.
     */
    protected function generateTagihan(Pinjaman $pinjaman): void
    {
        // Hindari duplikasi generation jika admin tidak sengaja trigger ulang
        if (TagihanPinjaman::where('pinjaman_id', $pinjaman->id)->exists()) {
            return;
        }

        $tenor = $pinjaman->tenor_bulan;
        $totalPinjaman = $pinjaman->jumlah_pinjaman;
        $bungaPersen = $pinjaman->bunga_persen;
        
        $pokokPerBulan = $totalPinjaman / $tenor;
        $bungaPerBulan = ($totalPinjaman * ($bungaPersen / 100)) / $tenor;
        $totalTagihanPerBulan = $pokokPerBulan + $bungaPerBulan;

        $now = Carbon::now();

        $tagihanData = [];
        for ($i = 1; $i <= $tenor; $i++) {
            $jatuhTempo = $now->copy()->addMonths($i);

            $tagihanData[] = [
                'kode_tagihan' => 'TGH-' . $pinjaman->id . '-' . date('Ymd') . '-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'pinjaman_id' => $pinjaman->id,
                'tagihan_ke' => $i,
                'jatuh_tempo' => $jatuhTempo->toDateString(),
                'nominal_pokok' => $pokokPerBulan,
                'nominal_bunga' => $bungaPerBulan,
                'total_tagihan' => $totalTagihanPerBulan,
                'status' => 'Belum Dibayar',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert massal untuk kecepatan super tinggi
        TagihanPinjaman::insert($tagihanData);
    }
}
