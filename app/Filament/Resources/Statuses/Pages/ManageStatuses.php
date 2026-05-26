<?php

namespace App\Filament\Resources\Statuses\Pages;

use App\Filament\Resources\Statuses\StatusResource;
use App\Filament\Support\DefaultActionGroup;
use Filament\Resources\Pages\ManageRecords;

class ManageStatuses extends ManageRecords
{
    protected static string $resource = StatusResource::class;

    public function getBreadcrumbs(): array
    {
        return [
            url('/admin') => 'Dashboard',
            '' => 'Status Kepegawaian',
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            DefaultActionGroup::create('sm'),
        ];
    }
}
