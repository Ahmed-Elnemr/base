<?php

use Illuminate\Support\Facades\Route;
use Modules\ServiceWork\Http\Controllers\ServiceWorkController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('serviceworks', ServiceWorkController::class)->names('servicework');
});
