<?php

namespace App\Filament\Member\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class MemberDashboard extends BaseDashboard
{
    public function getBreadcrumbs(): array
    {
        return [
            url('/member') => 'Dashboard Member',
        ];
    }
}
