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
        $totalSukarela = $totalSimpanan ? $totalSimpanan->total_simpanan_sukarela : 0;

        $sisaTagihan = TagihanPinjaman::whereHas('pinjaman', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->whereIn('status', ['Belum Dibayar', 'Menunggu Verifikasi'])->sum('total_tagihan');

        return [
            Stat::make('Total Tabungan', 'Rp ' . number_format($totalDana, 0, ',', '.'))
                ->descriptionIcon('heroicon-m-wallet')
                ->color('success'),

            Stat::make('Simpanan Sukarela', 'Rp ' . number_format($totalSukarela, 0, ',', '.'))
                ->description('Tersedia untuk ditarik')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('info'),

            Stat::make('Sisa Tagihan', 'Rp ' . number_format($sisaTagihan, 0, ',', '.'))
                ->description($sisaTagihan > 0 ? 'Segera lunasi' : 'Lunas ✅')
                ->descriptionIcon($sisaTagihan > 0 ? 'heroicon-m-exclamation-circle' : 'heroicon-m-check-circle')
                ->color($sisaTagihan > 0 ? 'danger' : 'success'),
        ];
    }
}
