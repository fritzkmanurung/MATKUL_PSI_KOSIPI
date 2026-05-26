<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class AdminDashboard extends BaseDashboard
{
    public function getBreadcrumbs(): array
    {
        return [
            url('/admin') => 'Dashboard',
        ];
    }
}
