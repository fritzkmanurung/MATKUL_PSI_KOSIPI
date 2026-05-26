<?php

namespace App\Filament\Member\Resources\PenarikanAnggotas\Pages;

use App\Filament\Member\Resources\PenarikanAnggotas\PenarikanAnggotaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPenarikanAnggotas extends ListRecords
{
    protected static string $resource = PenarikanAnggotaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['user_id'] = auth()->id();
                    $data['tanggal_penarikan'] = now()->toDateString();
                    return $data;
                })
                ->modalWidth('md')
                ->modalHeading(new \Illuminate\Support\HtmlString('
                    <div class="flex items-center gap-3 pb-2 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-primary-500/10 text-primary-600">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" /></svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">Tarik Simpanan</h2>
                            <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Ajukan penarikan dari saldo simpanan sukarela Anda.</p>
                        </div>
                    </div>
                ')),
        ];
    }
}
