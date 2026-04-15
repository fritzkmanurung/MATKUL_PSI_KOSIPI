<?php

use Illuminate\Support\Facades\Route;
use Modules\Sistem\Http\Controllers\SistemController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('sistems', SistemController::class)->names('sistem');
});
