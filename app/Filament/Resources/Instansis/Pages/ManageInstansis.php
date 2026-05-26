<?php

namespace App\Filament\Resources\Instansis\Pages;

use App\Filament\Resources\Instansis\InstansiResource;
use App\Filament\Support\DefaultActionGroup;
use Filament\Resources\Pages\ManageRecords;

class ManageInstansis extends ManageRecords
{
    protected static string $resource = InstansiResource::class;

    public function getBreadcrumbs(): array
    {
        return [
            url('/admin') => 'Dashboard',
            '' => 'Instansi',
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            DefaultActionGroup::create('sm'),
        ];
    }
}
