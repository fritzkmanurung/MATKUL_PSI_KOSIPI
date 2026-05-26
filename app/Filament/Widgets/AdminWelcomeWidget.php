<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Modules\Simpanan\Models\Simpanan;
use Modules\Pinjaman\Models\Pinjaman;

class AdminWelcomeWidget extends Widget
{
    protected string $view = 'filament.widgets.admin-welcome-widget';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = -1;

    public static function canView(): bool
    {
        return auth()->user()->hasRole(['Super Admin', 'Admin', 'Bendahara']);
    }

    protected function getViewData(): array
    {
        $pendingSimpanan = Simpanan::where('status', 'Menunggu')->count();
        $pendingPinjaman = Pinjaman::where('status', 'Menunggu')->count();

        return [
            'pendingSimpanan' => $pendingSimpanan,
            'pendingPinjaman' => $pendingPinjaman,
        ];
    }
}
