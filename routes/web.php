<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('admin');
});
Route::post('/support/messages', [HomeController::class, 'submitSupport'])->name('support.message.store');
