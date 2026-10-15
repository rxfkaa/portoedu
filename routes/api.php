<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login'])
    ->middleware('throttle:10,1')
    ->name('auth.login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me'])->name('auth.me');
    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::middleware('admin')->name('api.')->group(function () {
        Route::apiResource('users', UserController::class);
    });
});
