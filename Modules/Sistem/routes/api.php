<?php

use Illuminate\Support\Facades\Route;
use Modules\Sistem\Http\Controllers\SistemController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('sistems', SistemController::class)->names('sistem');
});
