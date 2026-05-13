<?php

use Illuminate\Support\Facades\Route;
use Modules\Setting\Http\Controllers\Api\HomeController;
use Modules\Setting\Http\Controllers\SettingController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('settings', SettingController::class)->names('setting');
});

Route::middleware([''])->prefix('v1')->group(function () {
    Route::get('home', [HomeController::class,'home']);
});
Route::prefix('v1')->group(function () {
    Route::get('all-settings', [\Modules\Setting\Http\Controllers\Api\SettingController::class, 'all']);
    Route::get('settings/{key}', [\Modules\Setting\Http\Controllers\Api\SettingController::class, 'showByKey']);
});
