<?php

use Illuminate\Support\Facades\Route;
use Modules\ServiceWork\app\Http\Controllers\Api\ServiceWorkController;

Route::prefix('v1')->group(function () {
    Route::get('service-works/categories/{slug}', [ServiceWorkController::class, 'show'])
        ->name('api.service-works.categories.show');
});
