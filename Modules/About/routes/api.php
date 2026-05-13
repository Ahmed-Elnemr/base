<?php

use Illuminate\Support\Facades\Route;
use Modules\About\Http\Controllers\AboutController;

Route::prefix('v1')->group(function () {
    Route::get('about', AboutController::class)->name('api.about.show');
});
