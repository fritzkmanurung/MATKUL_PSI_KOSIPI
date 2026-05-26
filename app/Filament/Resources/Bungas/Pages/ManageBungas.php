<?php

namespace App\Filament\Resources\Bungas\Pages;

use App\Filament\Resources\Bungas\BungaResource;
use App\Filament\Support\DefaultActionGroup;
use Filament\Resources\Pages\ManageRecords;

class ManageBungas extends ManageRecords
{
    protected static string $resource = BungaResource::class;

    public function getBreadcrumbs(): array
    {
        return [
            url('/admin') => 'Dashboard',
            '' => 'Suku Bunga',
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            DefaultActionGroup::create('md'),
        ];
    }
}
