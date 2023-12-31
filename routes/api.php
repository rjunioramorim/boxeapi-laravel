<?php

use App\Http\Controllers\Api\Auth\GetProfileController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\UpdateProfileController;
use App\Http\Controllers\Api\Checkins\CancelCheckinsController;
use App\Http\Controllers\Api\Checkins\CreateCheckinsController;
use App\Http\Controllers\Api\Checkins\GetCheckinOnDayController;
use App\Http\Controllers\Api\Checkins\ListCheckinsController;
use App\Http\Controllers\Api\Schedules\DetailSchedulesController;
use App\Http\Controllers\Api\Schedules\ListSchedulesController;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;


Route::post('/auth/session', LoginController::class);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/auth/logout', LogoutController::class);
    Route::get('/auth/me', GetProfileController::class);
    Route::post('/auth/me', UpdateProfileController::class);
       
    Route::get('/schedules', ListSchedulesController::class);
    Route::get('/schedules/{schedule}/{day}', DetailSchedulesController::class);
    Route::post('/checkins', CreateCheckinsController::class);
    Route::get('/checkins', ListCheckinsController::class);
    Route::get('/checkins-day', GetCheckinOnDayController::class);
    Route::put('/checkins/{checkin}', CancelCheckinsController::class);
});
