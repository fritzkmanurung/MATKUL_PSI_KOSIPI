<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Simpanan\Models\Simpanan;
use Modules\Pinjaman\Models\Pinjaman;

class ArusKasChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Arus Kas Bulanan (Tahun Berjalan)';
    protected static ?int $sort = 2; // Tampil di urutan kedua

    public static function canView(): bool
    {
        return auth()->user()->hasRole(['Super Admin', 'Admin', 'Bendahara']);
    }

    protected function getData(): array
    {
        $currentYear = date('Y');
        
        $simpananData = [];
        $pinjamanData = [];

        // Manual iteration untk 12 bulan (Jan-Dec) jika tak pakai plugin Tren
        for ($month = 1; $month <= 12; $month++) {
            $simpananData[] = Simpanan::whereYear('waktu_simpanan', $currentYear)
                                ->whereMonth('waktu_simpanan', $month)
                                ->where('status', 'Diterima')
                                ->sum('nominal_simpanan');
                                
            $pinjamanData[] = Pinjaman::whereYear('tanggal_pinjaman', $currentYear)
                                ->whereMonth('tanggal_pinjaman', $month)
                                ->where('status', 'Disetujui')
                                ->sum('jumlah_pinjaman');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Simpanan Masuk',
                    'data' => $simpananData,
                    'borderColor' => '#10b981', // green / success
                    'backgroundColor' => 'rgba(16, 185, 129, 0.2)',
                    'fill' => true,
                ],
                [
                    'label' => 'Total Pinjaman Keluar',
                    'data' => $pinjamanData,
                    'borderColor' => '#f43f5e', // rose / danger
                    'backgroundColor' => 'rgba(244, 63, 94, 0.2)',
                    'fill' => true,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
