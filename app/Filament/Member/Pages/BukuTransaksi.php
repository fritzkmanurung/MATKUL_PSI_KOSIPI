<?php

namespace App\Filament\Member\Pages;

use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Collection;
use Modules\Simpanan\Models\Simpanan;
use Modules\Simpanan\Models\Penarikan;
use Modules\Simpanan\Models\TotalSimpanan;
use Modules\Pinjaman\Models\Pinjaman;
use Modules\Pinjaman\Models\TagihanPinjaman;
use BackedEnum;

class BukuTransaksi extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;
    protected static ?string $navigationLabel = 'Buku Transaksi';
    protected static ?string $title = 'Buku Transaksi Saya';
    protected static ?int $navigationSort = 0;

    protected string $view = 'filament.member.pages.buku-transaksi';

    public function getBreadcrumbs(): array
    {
        return [
            url('/member') => 'Dashboard Member',
            '' => 'Buku Transaksi',
        ];
    }

    public function getViewData(): array
    {
        $userId = auth()->id();

        // Rekap Saldo
        $totalSimpanan = TotalSimpanan::where('user_id', $userId)->first();

        // Kumpulkan semua transaksi jadi satu koleksi
        $transaksi = collect();

        // 1. Simpanan (Setoran Masuk)
        $simpanans = Simpanan::where('user_id', $userId)
            ->where('status', 'Diterima')
            ->get()
            ->map(fn ($s) => [
                'tanggal' => $s->waktu_simpanan ?? $s->created_at->format('Y-m-d'),
                'keterangan' => 'Simpanan ' . $s->jenis_simpanan,
                'jenis' => 'Simpanan',
                'kategori' => $s->jenis_simpanan,
                'masuk' => $s->nominal_simpanan,
                'keluar' => 0,
                'status' => $s->status,
                'icon' => 'arrow-down-circle',
                'color' => 'success',
            ]);
        $transaksi = $transaksi->merge($simpanans);

        // 2. Penarikan (Dana Keluar)
        $penarikans = Penarikan::where('user_id', $userId)
            ->where('status', 'Disetujui')
            ->get()
            ->map(fn ($p) => [
                'tanggal' => $p->tanggal_penarikan ?? $p->created_at->format('Y-m-d'),
                'keterangan' => 'Penarikan Sukarela',
                'jenis' => 'Penarikan',
                'kategori' => 'Sukarela',
                'masuk' => 0,
                'keluar' => $p->nominal_penarikan,
                'status' => $p->status,
                'icon' => 'arrow-up-circle',
                'color' => 'danger',
            ]);
        $transaksi = $transaksi->merge($penarikans);

        // 3. Pinjaman Diterima (Dana Masuk dari Pinjaman)
        $pinjamans = Pinjaman::where('user_id', $userId)
            ->where('status', 'Disetujui')
            ->get()
            ->map(fn ($p) => [
                'tanggal' => $p->tanggal_pinjaman ?? $p->created_at->format('Y-m-d'),
                'keterangan' => 'Pencairan Pinjaman (' . $p->kode_pinjaman . ')',
                'jenis' => 'Pinjaman',
                'kategori' => 'Pencairan',
                'masuk' => $p->jumlah_pinjaman,
                'keluar' => 0,
                'status' => $p->status,
                'icon' => 'banknotes',
                'color' => 'info',
            ]);
        $transaksi = $transaksi->merge($pinjamans);

        // 4. Angsuran Pinjaman (Dana Keluar)
        $angsurans = TagihanPinjaman::whereHas('pinjaman', fn ($q) => $q->where('user_id', $userId))
            ->where('status', 'Lunas')
            ->get()
            ->map(fn ($t) => [
                'tanggal' => $t->tanggal_bayar ?? $t->created_at->format('Y-m-d'),
                'keterangan' => 'Angsuran ke-' . $t->tagihan_ke . ' (' . $t->kode_tagihan . ')',
                'jenis' => 'Angsuran',
                'kategori' => 'Cicilan',
                'masuk' => 0,
                'keluar' => $t->total_tagihan,
                'status' => $t->status,
                'icon' => 'arrow-up-circle',
                'color' => 'warning',
            ]);
        $transaksi = $transaksi->merge($angsurans);

        // Urutkan berdasarkan tanggal terbaru
        $transaksi = $transaksi->sortByDesc('tanggal')->values();

        // Hitung ringkasan
        $totalMasuk = $transaksi->sum('masuk');
        $totalKeluar = $transaksi->sum('keluar');

        return [
            'totalSimpanan' => $totalSimpanan,
            'transaksi' => $transaksi,
            'totalMasuk' => $totalMasuk,
            'totalKeluar' => $totalKeluar,
        ];
    }
}
