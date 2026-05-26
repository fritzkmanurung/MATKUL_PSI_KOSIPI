<?php

namespace App\Filament\Member\Resources\PinjamanAnggotas\Pages;

use App\Filament\Member\Resources\PinjamanAnggotas\PinjamanAnggotaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPinjamanAnggotas extends ListRecords
{
    protected static string $resource = PinjamanAnggotaResource::class;

    protected function getHeaderActions(): array
    {
        $userId = auth()->id();
        $hasAktif = \Modules\Pinjaman\Models\Pinjaman::hasAktifPinjaman($userId);
        $tunggakan = \Modules\Pinjaman\Models\Pinjaman::hasTunggakan($userId);

        return [
            CreateAction::make()
                ->visible(!$hasAktif && !$tunggakan['ada_tunggakan']),
        ];
    }
}
