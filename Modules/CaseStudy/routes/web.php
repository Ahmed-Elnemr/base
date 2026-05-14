<?php

use Illuminate\Support\Facades\Route;
use Modules\CaseStudy\Http\Controllers\CaseStudyController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('casestudies', CaseStudyController::class)->names('casestudy');
});
