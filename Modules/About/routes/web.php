<?php

use Illuminate\Support\Facades\Route;
use Modules\About\Http\Controllers\AboutController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('abouts', AboutController::class)->names('about');
});
