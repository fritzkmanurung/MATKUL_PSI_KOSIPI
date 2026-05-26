<?php

namespace App\Filament\Resources\TagihanPinjamen\Pages;

use App\Filament\Resources\TagihanPinjamen\TagihanPinjamanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTagihanPinjamen extends ListRecords
{
    protected static string $resource = TagihanPinjamanResource::class;

    public function getBreadcrumbs(): array
    {
        return [
            url('/admin') => 'Dashboard',
            '' => 'Tagihan Pinjaman',
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
            'Menunggu Verifikasi' => \Filament\Schemas\Components\Tabs\Tab::make()
                ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->where('status', 'Menunggu Verifikasi')),
            'Lunas' => \Filament\Schemas\Components\Tabs\Tab::make()
                ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->where('status', 'Lunas')),
            'Revisi' => \Filament\Schemas\Components\Tabs\Tab::make()
                ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->where('status', 'Revisi')),
            'Ditolak' => \Filament\Schemas\Components\Tabs\Tab::make()
                ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->where('status', 'Ditolak')),
        ];
    }
}