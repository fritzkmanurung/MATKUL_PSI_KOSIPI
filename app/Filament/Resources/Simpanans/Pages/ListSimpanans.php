<?php

namespace App\Filament\Resources\Simpanans\Pages;

use App\Filament\Resources\Simpanans\SimpananResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSimpanans extends ListRecords
{
    protected static string $resource = SimpananResource::class;
    
    public function getBreadcrumbs(): array
    {
        return [
            url('/admin') => 'Dashboard',
            '' => 'Simpanan',
        ];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getTabs(): array
    {
        return [
            'Semua' => \Filament\Schemas\Components\Tabs\Tab::make(),
            'Pokok' => \Filament\Schemas\Components\Tabs\Tab::make()
                ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->where('jenis_simpanan', 'Pokok')),
            'Wajib' => \Filament\Schemas\Components\Tabs\Tab::make()
                ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->where('jenis_simpanan', 'Wajib')),
            'Sukarela' => \Filament\Schemas\Components\Tabs\Tab::make()
                ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->where('jenis_simpanan', 'Sukarela')),
        ];
    }
}
