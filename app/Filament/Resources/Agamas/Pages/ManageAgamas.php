<?php

namespace App\Filament\Resources\Agamas\Pages;

use App\Filament\Resources\Agamas\AgamaResource;
use App\Filament\Support\DefaultActionGroup;
use Filament\Resources\Pages\ManageRecords;

class ManageAgamas extends ManageRecords
{
    protected static string $resource = AgamaResource::class;

    public function getBreadcrumbs(): array
    {
        return [
            url('/admin') => 'Dashboard',
            '' => 'Agama',
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            DefaultActionGroup::create('sm'),
        ];
    }
}
