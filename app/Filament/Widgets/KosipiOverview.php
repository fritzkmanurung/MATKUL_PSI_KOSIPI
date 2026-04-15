<?php

namespace App\Filament\Widgets;

use Modules\Simpanan\Models\Simpanan;
use Modules\Pinjaman\Models\Pinjaman;
use Modules\Pinjaman\Models\TagihanPinjaman;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class KosipiOverview extends BaseWidget
{
    public static function canView(): bool
    {
        // Hanya dikembalikan true jika User Super Admin atau Bendahara
        return auth()->user()->hasRole(['Super Admin', 'Admin', 'Bendahara']);
    }

    protected function getStats(): array
    {
        // 1. Aset Likuid (Kas di Tangan) = Total Simpanan (Sukarela, Wajib, Pokok) yang Diterima
        $totalSimpanan = Simpanan::where('status', 'Diterima')->sum('nominal_simpanan');
        
        // 2. Piutang (Uang Beredar) = Sisa Tagihan Pinjaman Pokok yang belum dibayar
        $totalPiutang = TagihanPinjaman::where('status', 'Belum Dibayar')
                        ->orWhere('status', 'Menunggu Verifikasi')
                        ->sum('nominal_pokok');
                        
        // 3. Laba Koperasi (Est. Bunga Lunas) = Total bunga yang sudah dilunasi
        $totalLaba = TagihanPinjaman::where('status', 'Lunas')->sum('nominal_bunga');
        
        // 4. Jumlah Anggota Aktif
        $totalAnggota = User::role('Anggota')->count();

        return [
            Stat::make('Total Aset (Kas Koperasi)', 'Rp ' . number_format($totalSimpanan, 0, ',', '.'))
                ->description('Total tumpukan dana dari anggota')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
                
            Stat::make('Total Piutang Berjalan', 'Rp ' . number_format($totalPiutang, 0, ',', '.'))
                ->description('Uang beredar pada Pinjaman aktif')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('info'),
                
            Stat::make('Laba Bersih Pinjaman', 'Rp ' . number_format($totalLaba, 0, ',', '.'))
                ->description('Total Bunga yang telah dibayar')
                ->descriptionIcon('heroicon-m-sparkles')
                ->color('warning'),
                
            Stat::make('Anggota Aktif', $totalAnggota . ' Orang')
                ->description('Basis jaringan KOSIPI')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
        ];
    }
}
