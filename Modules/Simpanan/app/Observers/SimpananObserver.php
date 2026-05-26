<?php

namespace Modules\Simpanan\Observers;

use Modules\Simpanan\Models\Simpanan;
use Modules\Simpanan\Models\TotalSimpanan;

class SimpananObserver
{
    public function saved(Simpanan $simpanan): void
    {
        TotalSimpanan::recalculate($simpanan->user_id);
    }

    public function created(Simpanan $simpanan): void
    {
        $admins = \App\Models\User::role(\App\Support\RoleConstant::adminRoles())->get();
        \Filament\Notifications\Notification::make()
            ->title('Setoran Baru')
            ->body('Ada setoran simpanan masuk memerlukan verifikasi.')
            ->info()
            ->sendToDatabase($admins);
    }

    public function updated(Simpanan $simpanan): void
    {
        if ($simpanan->isDirty('status')) {
            if ($simpanan->status === 'Diterima') {
                \Filament\Notifications\Notification::make()
                    ->title('Simpanan Diterima')
                    ->body('Setoran senilai Rp' . number_format($simpanan->nominal_simpanan, 0, ',', '.') . ' telah diverifikasi.')
                    ->success()
                    ->sendToDatabase($simpanan->user);
            } elseif ($simpanan->status === 'Ditolak') {
                \Filament\Notifications\Notification::make()
                    ->title('Simpanan Ditolak')
                    ->body($simpanan->catatan_penolakan ?? 'Silakan periksa kembali bukti yang Anda unggah.')
                    ->danger()
                    ->sendToDatabase($simpanan->user);
            }
        }
    }

    public function deleted(Simpanan $simpanan): void
    {
        TotalSimpanan::recalculate($simpanan->user_id);
    }
}
