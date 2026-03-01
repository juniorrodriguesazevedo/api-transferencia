<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Api\TransferController;
use App\Http\Controllers\Api\TransactionController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [UserController::class, 'store']);

Route::middleware(['auth:sanctum', 'throttle:30,1'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('/users', UserController::class)->except('store');

    Route::post('/transfers', TransferController::class);

    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show']);
});
