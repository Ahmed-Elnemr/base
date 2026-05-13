<?php

use Illuminate\Support\Facades\Route;
use Modules\Slider\Http\Controllers\SliderController;

Route::prefix('v1')->group(function () {
    Route::get('sliders', SliderController::class)->name('api.sliders.index');
});
