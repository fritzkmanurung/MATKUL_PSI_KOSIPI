<?php

use Illuminate\Support\Facades\Route;
use Modules\Pinjaman\Http\Controllers\PinjamanController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('pinjamen', PinjamanController::class)->names('pinjaman');
});
