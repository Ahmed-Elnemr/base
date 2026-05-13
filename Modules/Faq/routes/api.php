<?php

use Illuminate\Support\Facades\Route;
use Modules\Faq\Http\Controllers\FaqController;

Route::prefix('v1')->group(function () {
    Route::get('faqs', FaqController::class)->name('api.faqs.index');
});
