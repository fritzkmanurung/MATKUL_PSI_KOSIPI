<?php

namespace App\Filament\Support;

class StatusHelper
{
    public static function getColor(string $status): string
    {
        return match ($status) {
            'Aktif', 'Lunas', 'Disetujui', 'Disetujui Admin', 'Selesai', 'Diterima', 'Sukarela' => 'success',
            'Menunggu', 'Menunggu Dokumen', 'Proses', 'Pending', 'Revisi', 'Wajib' => 'warning',
            'Ditolak', 'Ditolak Dokumen', 'Batal', 'Non-aktif', 'Non-Aktif', 'Jatuh Tempo', 'Belum Dibayar' => 'danger',
            'Kontrak', 'Tetap', 'Pokok' => 'info',
            default => 'gray',
        };
    }

    public static function getIcon(string $status): string
    {
        return match ($status) {
            'Aktif', 'Lunas', 'Disetujui', 'Disetujui Admin', 'Selesai', 'Diterima' => 'heroicon-m-check-circle',
            'Menunggu', 'Menunggu Dokumen', 'Proses', 'Pending', 'Revisi' => 'heroicon-m-clock',
            'Ditolak', 'Ditolak Dokumen', 'Batal', 'Non-aktif', 'Non-Aktif', 'Jatuh Tempo', 'Belum Dibayar' => 'heroicon-m-x-circle',
            default => 'heroicon-m-question-mark-circle',
        };
    }

    /**
     * Helper untuk Filament Table Column atau Infolist Entry
     */
    public static function applyBadge(\Filament\Tables\Columns\TextColumn|\Filament\Infolists\Components\TextEntry $component): \Filament\Tables\Columns\TextColumn|\Filament\Infolists\Components\TextEntry
    {
        return $component
            ->badge()
            ->color(fn ($state) => self::getColor($state))
            ->icon(fn ($state) => self::getIcon($state));
    }
}
