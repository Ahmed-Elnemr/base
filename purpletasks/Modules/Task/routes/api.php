<?php

use Illuminate\Support\Facades\Route;
use Modules\Task\Http\Controllers\TaskController;

Route::middleware(['auth:sanctum'])->prefix('v1/tasks')->group(function () {
    Route::get('/', [TaskController::class, 'index']);
    Route::post('{id}/start', [TaskController::class, 'start']);
    Route::post('{id}/complete', [TaskController::class, 'complete']);
});
