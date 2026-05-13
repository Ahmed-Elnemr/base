<?php

use Illuminate\Support\Facades\Route;
use Modules\ServiceFlow\Http\Controllers\ServiceFlowController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('serviceflows', ServiceFlowController::class)->names('serviceflow');
});
