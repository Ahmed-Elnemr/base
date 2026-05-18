<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('admin');
});
Route::post('/support/messages', [HomeController::class, 'submitSupport'])->name('support.message.store');

Route::get('/run-link', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('storage:link');

        return 'Storage link created successfully!';
    } catch (\Exception $e) {
        return 'Error: '.$e->getMessage();
    }
});

Route::get('/run-clear', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('route:clear');
        \Illuminate\Support\Facades\Artisan::call('view:clear');

        return 'Cache, Config, Routes, and Views cleared successfully!';
    } catch (\Exception $e) {
        return 'Error: '.$e->getMessage();
    }
});
