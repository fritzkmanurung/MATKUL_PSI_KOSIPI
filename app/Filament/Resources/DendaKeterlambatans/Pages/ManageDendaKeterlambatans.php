<?php

namespace App\Filament\Resources\DendaKeterlambatans\Pages;

use App\Filament\Resources\DendaKeterlambatans\DendaKeterlambatanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageDendaKeterlambatans extends ManageRecords
{
    protected static string $resource = DendaKeterlambatanResource::class;

    public function getBreadcrumbs(): array
    {
        return [
            url('/admin') => 'Dashboard',
            '' => 'Denda Keterlambatan',
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            \App\Filament\Support\DefaultActionGroup::create('md'),
        ];
    }
}
