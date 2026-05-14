<?php

use Illuminate\Support\Facades\Route;
use Modules\Service\Http\Controllers\ServiceController;

Route::prefix('v1')->group(function () {
    Route::get('services/categories', [ServiceController::class, 'index'])->name('api.services.categories');
    Route::get('services', [ServiceController::class, 'list'])->name('api.services.list');
    Route::get('services/{slug}', [ServiceController::class, 'show'])->name('api.services.show');
});
