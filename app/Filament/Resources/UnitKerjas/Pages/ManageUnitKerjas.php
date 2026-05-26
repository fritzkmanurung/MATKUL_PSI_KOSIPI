<?php

namespace App\Filament\Resources\UnitKerjas\Pages;

use App\Filament\Resources\UnitKerjas\UnitKerjaResource;
use App\Filament\Support\DefaultActionGroup;
use Filament\Resources\Pages\ManageRecords;

class ManageUnitKerjas extends ManageRecords
{
    protected static string $resource = UnitKerjaResource::class;

    public function getBreadcrumbs(): array
    {
        return [
            url('/admin') => 'Dashboard',
            '' => 'Unit Kerja',
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            DefaultActionGroup::create('sm'),
        ];
    }
}
