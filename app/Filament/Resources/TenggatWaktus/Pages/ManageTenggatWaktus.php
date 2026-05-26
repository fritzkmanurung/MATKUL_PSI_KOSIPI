<?php

namespace App\Filament\Resources\TenggatWaktus\Pages;

use App\Filament\Resources\TenggatWaktus\TenggatWaktuResource;
use App\Filament\Support\DefaultActionGroup;
use Filament\Resources\Pages\ManageRecords;

class ManageTenggatWaktus extends ManageRecords
{
    protected static string $resource = TenggatWaktuResource::class;

    public function getBreadcrumbs(): array
    {
        return [
            url('/admin') => 'Dashboard',
            '' => 'Tenggat Bayar',
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            DefaultActionGroup::create('md'),
        ];
    }
}
