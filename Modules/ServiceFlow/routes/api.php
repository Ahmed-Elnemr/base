<?php

use Illuminate\Support\Facades\Route;
use Modules\ServiceFlow\Http\Controllers\ServiceFlowController;

Route::prefix('v1')->group(function () {
    Route::get('service-flow', ServiceFlowController::class)->name('api.service-flow.index');
});
