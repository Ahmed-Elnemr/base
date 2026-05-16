<?php

use Illuminate\Support\Facades\Route;
use Modules\Setting\Http\Controllers\Api\HomeController;
use Modules\Setting\Http\Controllers\SettingController;

Route::prefix('v1')->group(function () {
    Route::get('settings', [\Modules\Setting\Http\Controllers\Api\SettingController::class, 'settings']);
});
