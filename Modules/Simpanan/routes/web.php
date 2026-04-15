<?php

use Illuminate\Support\Facades\Route;
use Modules\Simpanan\Http\Controllers\SimpananController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('simpanans', SimpananController::class)->names('simpanan');
});
