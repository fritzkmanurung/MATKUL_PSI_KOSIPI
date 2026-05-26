<?php

namespace App\Filament\Member\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class RecentTransactionsWidget extends Widget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';
    protected string $view = 'filament.member.widgets.recent-transactions-widget';

    protected function getViewData(): array
    {
        $userId = auth()->id();

        $transactions = DB::query()
            ->fromSub(function ($query) use ($userId) {
                $query->select(
                    DB::raw("'Simpanan' as jenis"),
                    DB::raw('waktu_simpanan as tanggal'),
                    DB::raw('nominal_simpanan as nominal'),
                    'status',
                )
                ->from('simpanans')
                ->where('user_id', $userId)
                ->unionAll(
                    DB::query()->select(
                        DB::raw("'Penarikan' as jenis"),
                        DB::raw('tanggal_penarikan as tanggal'),
                        DB::raw('nominal_penarikan as nominal'),
                        'status',
                    )
                    ->from('penarikans')
                    ->where('user_id', $userId)
                )
                ->unionAll(
                    DB::query()->select(
                        DB::raw("'Pinjaman' as jenis"),
                        DB::raw('tanggal_pinjaman as tanggal'),
                        DB::raw('jumlah_pinjaman as nominal'),
                        'status',
                    )
                    ->from('pinjamans')
                    ->where('user_id', $userId)
                );
            }, 'combined')
            ->orderByDesc('tanggal')
            ->limit(5)
            ->get();

        return [
            'transactions' => $transactions,
        ];
    }
}
