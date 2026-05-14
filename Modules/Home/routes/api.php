<?php

use Illuminate\Support\Facades\Route;
use Modules\Home\Http\Controllers\HomeController;

Route::prefix('v1')->group(function () {
    Route::get('home', [\Modules\Home\Http\Controllers\Api\HomeController::class, 'home']);
});
