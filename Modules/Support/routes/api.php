<?php

use Illuminate\Support\Facades\Route;
use Modules\Support\Http\Controllers\SupportController;

Route::prefix('v1')->group(function () {
    Route::get('support', [SupportController::class, 'show'])->name('api.support.show');
    Route::post('support/messages', [SupportController::class, 'store'])->name('api.support.store');
});
