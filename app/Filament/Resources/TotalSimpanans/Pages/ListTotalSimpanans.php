<?php

namespace App\Filament\Resources\TotalSimpanans\Pages;

use App\Filament\Resources\TotalSimpanans\TotalSimpananResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTotalSimpanans extends ListRecords
{
    protected static string $resource = TotalSimpananResource::class;

    public function getBreadcrumbs(): array
    {
        return [
            url('/admin') => 'Dashboard',
            '' => 'Total Simpanan',
        ];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
