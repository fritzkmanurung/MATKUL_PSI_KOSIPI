<?php

use Illuminate\Support\Facades\Route;
use Modules\Simpanan\Http\Controllers\SimpananController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('simpanans', SimpananController::class)->names('simpanan');
});
