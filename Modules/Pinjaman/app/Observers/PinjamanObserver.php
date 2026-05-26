<?php

namespace Modules\Pinjaman\Observers;

use Modules\Pinjaman\Models\Pinjaman;
use Modules\Pinjaman\Models\TagihanPinjaman;
use Illuminate\Support\Carbon;

class PinjamanObserver
{
    public function created(Pinjaman $pinjaman): void
    {
        $admins = \App\Models\User::role(\App\Support\RoleConstant::adminRoles())->get();
        \Filament\Notifications\Notification::make()
            ->title('Pengajuan Pinjaman Baru')
            ->body('Ada pengajuan pinjaman baru yang menunggu ulasan.')
            ->info()
            ->sendToDatabase($admins);
    }

    /**
     * Listen to the Pinjaman "updated" event.
     */
    public function updated(Pinjaman $pinjaman): void
    {
        // Notifikasi ke anggota
        if ($pinjaman->isDirty('status')) {
            if ($pinjaman->status === 'Menunggu Dokumen') {
                \Filament\Notifications\Notification::make()
                    ->title('Pinjaman Disetujui (Tahap 1)')
                    ->body('Harap lengkapi dan unggah dokumen persetujuan.')
                    ->warning()
                    ->sendToDatabase($pinjaman->user);
            } elseif ($pinjaman->status === 'Menunggu Verifikasi Dokumen') {
                $admins = \App\Models\User::role(\App\Support\RoleConstant::adminRoles())->get();
                \Filament\Notifications\Notification::make()
                    ->title('Dokumen Pinjaman Diunggah')
                    ->body('Anggota telah mengunggah persetujuan kredit.')
                    ->info()
                    ->sendToDatabase($admins);
            } elseif ($pinjaman->status === 'Disetujui') {
                \Filament\Notifications\Notification::make()
                    ->title('Dana Dicairkan')
                    ->body('Pinjaman Anda senilai Rp' . number_format($pinjaman->jumlah_pinjaman, 0, ',', '.') . ' telah disetujui & dicairkan.')
                    ->success()
                    ->sendToDatabase($pinjaman->user);
                
                // Men-generate tagihan
                $this->generateTagihan($pinjaman);
            } elseif (in_array($pinjaman->status, ['Ditolak', 'Ditolak Dokumen'])) {
                \Filament\Notifications\Notification::make()
                    ->title('Pinjaman Ditolak')
                    ->body($pinjaman->catatan_penolakan ?? 'Pengajuan atau dokumen Anda ditolak.')
                    ->danger()
                    ->sendToDatabase($pinjaman->user);
            }
        }
    }

    /**
     * Logic Pintar (Bunga Menurun) untuk mengenerate otomatis baris tagihan cicilan.
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

        $now = Carbon::now();
        
        $tenggatPinjaman = \Modules\Sistem\Models\TenggatWaktu::getAktif('Pinjaman');
        $tanggalAkhir = $tenggatPinjaman ? $tenggatPinjaman->tanggal_akhir : 10;

        $tagihanData = [];
        $sisaPokok = $totalPinjaman;

        for ($i = 1; $i <= $tenor; $i++) {
            // Jatuh tempo setiap bulannya berdasarkan konfigurasi Tenggat Waktu Pinjaman
            $jatuhTempo = $now->copy()->addMonths($i)->setDay($tanggalAkhir);

            // Perhitungan bunga menurun berdasarkan sisa pokok
            $bungaPerBulan = ($sisaPokok * ($bungaPersen / 100));
            $totalTagihanPerBulan = $pokokPerBulan + $bungaPerBulan;

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

            $sisaPokok -= $pokokPerBulan;
        }

        // Insert massal untuk kecepatan super tinggi
        TagihanPinjaman::insert($tagihanData);
    }
}
