<?php

use Illuminate\Support\Facades\Route;
use Modules\CaseStudy\Http\Controllers\CaseStudyController;

Route::prefix('v1')->group(function () {
    Route::get('case-studies', [CaseStudyController::class, 'index'])->name('api.case-studies.index');
    Route::get('case-studies/{slug}', [CaseStudyController::class, 'show'])->name('api.case-studies.show');
});
