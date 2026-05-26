<?php

namespace App\Filament\Member\Resources\SimpananAnggotas\Pages;

use App\Filament\Member\Resources\SimpananAnggotas\SimpananAnggotaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSimpananAnggotas extends ListRecords
{
    protected static string $resource = SimpananAnggotaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modalWidth('md')
                ->mutateFormDataUsing(function (array $data): array {
                    $data['user_id'] = auth()->id();
                    return $data;
                }),
        ];
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
