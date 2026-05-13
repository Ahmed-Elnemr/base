<?php

use Illuminate\Support\Facades\Route;
use Modules\Catalog\Http\Controllers\CategoryApiController;
use Modules\Catalog\Http\Controllers\ServiceApiController;

Route::prefix('v1')->group(function () {
    Route::get('categories', [CategoryApiController::class, 'index'])->name('api.categories.index');
    Route::get('categories/{category}', [CategoryApiController::class, 'show'])->name('api.categories.show');

    Route::get('services', [ServiceApiController::class, 'index'])->name('api.services.index');
    Route::get('services/{service}', [ServiceApiController::class, 'show'])->name('api.services.show');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('user/create/services', [ServiceApiController::class, 'store']);
        Route::get('user/services', [ServiceApiController::class, 'myServices']);
        Route::delete('user/services/{id}', [ServiceApiController::class, 'destroy']);
        Route::post('user/services/{id}', [ServiceApiController::class, 'update']);
    });
});
