<?php

use Illuminate\Support\Facades\Route;
use Modules\Project\Http\Controllers\ProjectController;

Route::prefix('v1')->group(function () {
    Route::post('projects/submit', [ProjectController::class, 'submit'])->name('api.projects.submit');
    Route::get('projects/services', [ProjectController::class, 'services'])->name('api.projects.services');
});
