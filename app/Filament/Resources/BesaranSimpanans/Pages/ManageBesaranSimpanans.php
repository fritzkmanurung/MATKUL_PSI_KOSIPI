<?php

namespace App\Filament\Resources\BesaranSimpanans\Pages;

use App\Filament\Resources\BesaranSimpanans\BesaranSimpananResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageBesaranSimpanans extends ManageRecords
{
    protected static string $resource = BesaranSimpananResource::class;

    public function getBreadcrumbs(): array
    {
        return [
            url('/admin') => 'Dashboard',
            '' => 'Besaran Simpanan',
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            \App\Filament\Support\DefaultActionGroup::create('md'),
        ];
    }
}
