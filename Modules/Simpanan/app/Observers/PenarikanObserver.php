<?php

namespace Modules\Simpanan\Observers;

use Modules\Simpanan\Models\Penarikan;
use Modules\Simpanan\Models\TotalSimpanan;

class PenarikanObserver
{
    public function saved(Penarikan $penarikan): void
    {
        TotalSimpanan::recalculate($penarikan->user_id);
    }

    public function created(Penarikan $penarikan): void
    {
        $admins = \App\Models\User::role(['super_admin', 'admin', 'bendahara'])->get();
        \Filament\Notifications\Notification::make()
            ->title('Pengajuan Penarikan Baru')
            ->body('Anggota telah mengajukan penarikan saldo sukarela.')
            ->info()
            ->sendToDatabase($admins);
    }

    public function updated(Penarikan $penarikan): void
    {
        if ($penarikan->isDirty('status')) {
            if ($penarikan->status === 'Disetujui') {
                \Filament\Notifications\Notification::make()
                    ->title('Penarikan Disetujui')
                    ->body('Pengajuan Anda senilai Rp' . number_format($penarikan->nominal_penarikan, 0, ',', '.') . ' telah dicairkan.')
                    ->success()
                    ->sendToDatabase($penarikan->user);
            } elseif ($penarikan->status === 'Ditolak') {
                \Filament\Notifications\Notification::make()
                    ->title('Penarikan Ditolak')
                    ->body($penarikan->catatan_penolakan ?? 'Pengajuan penarikan belum dapat diproses.')
                    ->danger()
                    ->sendToDatabase($penarikan->user);
            }
        }
    }

    public function deleted(Penarikan $penarikan): void
    {
        TotalSimpanan::recalculate($penarikan->user_id);
    }
}
