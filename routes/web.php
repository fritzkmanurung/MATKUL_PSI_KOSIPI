<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    try {
        $totalMembers = \Modules\Keanggotaan\Models\Member::count();
        $totalSavings = \Modules\Simpanan\Models\Simpanan::where('status', 'Diterima')->sum('nominal_simpanan');
        $totalLoans = \Modules\Pinjaman\Models\Pinjaman::whereIn('status', ['Disetujui', 'Lunas'])->sum('jumlah_pinjaman');
    } catch (\Exception $e) {
        $totalMembers = 0;
        $totalSavings = 0;
        $totalLoans = 0;
    }

    return view('welcome', compact('totalMembers', 'totalSavings', 'totalLoans'));
});

Route::get('/login', function () {
    return redirect()->route('filament.member.auth.login');
})->name('login');

/**
 * Catch-all fallback route untuk halaman yang tidak ditemukan.
 * Ini akan redirect ke halaman 404 custom.
 */
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
