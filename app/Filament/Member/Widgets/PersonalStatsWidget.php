<?php

namespace App\Filament\Member\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Simpanan\Models\TotalSimpanan;
use Modules\Pinjaman\Models\TagihanPinjaman;

class PersonalStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $userId = auth()->id();
        
        $totalSimpanan = TotalSimpanan::where('user_id', $userId)->first();
        $totalDana = $totalSimpanan ? $totalSimpanan->total_simpanan : 0;

        $sisaTagihan = TagihanPinjaman::whereHas('pinjaman', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->whereIn('status', ['Belum Dibayar', 'Menunggu Verifikasi'])->sum('total_tagihan');

        return [
            Stat::make('Total Tabungan Anda', 'Rp ' . number_format($totalDana, 0, ',', '.'))
                ->description('Simpanan Pokok, Wajib, dan Sukarela')
                ->descriptionIcon('heroicon-m-wallet')
                ->color('success'),

            Stat::make('Sisa Tagihan Pinjaman', 'Rp ' . number_format($sisaTagihan, 0, ',', '.'))
                ->description('Tagihan bulan/jatuh tempo Anda')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color($sisaTagihan > 0 ? 'danger' : 'gray'),
        ];
    }
}
