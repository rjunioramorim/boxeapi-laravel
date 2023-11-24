<?php

use App\Http\Controllers\Api\Auth\GetProfileController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Schedules\SchedulesController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/session', LoginController::class);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/auth/me', GetProfileController::class);
    Route::post('/auth/logout', LogoutController::class);
    
    Route::get('/schedules', [SchedulesController::class, 'index']);
    // Route::get('/schedules', ListSchedulesController::class);
    // Route::get('/schedules/{schedule}/{day}', DetailSchedulesController::class);
    // Route::post('/checkins', CreateCheckinsController::class);
    // Route::get('/checkins', ListCheckinsController::class);
    // Route::put('/checkins/{checkin}', CancelCheckinsController::class);
});
