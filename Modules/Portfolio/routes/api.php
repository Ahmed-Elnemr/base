<?php

use Illuminate\Support\Facades\Route;
use Modules\Portfolio\Http\Controllers\WorkController;

Route::prefix('v1')->group(function () {
    Route::get('portfolio', [WorkController::class, 'index'])->name('api.portfolio.index');
});
