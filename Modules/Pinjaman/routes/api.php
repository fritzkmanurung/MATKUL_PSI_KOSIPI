<?php

use Illuminate\Support\Facades\Route;
use Modules\Pinjaman\Http\Controllers\PinjamanController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('pinjamen', PinjamanController::class)->names('pinjaman');
});
