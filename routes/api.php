<?php

use App\Http\Controllers\Api\Auth\GetProfileController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Checkins\CancelCheckinsController;
use App\Http\Controllers\Api\Checkins\CreateCheckinsController;
use App\Http\Controllers\Api\Checkins\ListCheckinsController;
use App\Http\Controllers\Api\Schedules\DetailSchedulesController;
use App\Http\Controllers\Api\Schedules\ListSchedulesController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/session', LoginController::class);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/auth/me', GetProfileController::class);
    Route::post('/auth/logout', LogoutController::class);
    Route::get('/schedules', ListSchedulesController::class);
    Route::get('/schedules/{schedule}/{day}', DetailSchedulesController::class);
    Route::post('/checkins', CreateCheckinsController::class);
    Route::get('/checkins', ListCheckinsController::class);
    Route::put('/checkins/{checkin}', CancelCheckinsController::class);
});
