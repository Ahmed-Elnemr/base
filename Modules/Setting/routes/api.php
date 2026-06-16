<?php

use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::get('settings', [\Modules\Setting\Http\Controllers\Api\SettingController::class, 'settings']);
});
