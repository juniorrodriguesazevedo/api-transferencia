<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Api\TransferController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'throttle:30,1'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('transfers', TransferController::class);
});
