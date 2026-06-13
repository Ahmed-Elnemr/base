<?php

use Illuminate\Support\Facades\Route;
use Modules\Attendance\Http\Controllers\AttendanceController;

Route::middleware(['auth:sanctum'])->prefix('v1/attendance')->group(function () {
    Route::post('clock-in', [AttendanceController::class, 'clockIn']);
    Route::post('clock-out', [AttendanceController::class, 'clockOut']);
    Route::get('status', [AttendanceController::class, 'status']);
    Route::get('summary', [AttendanceController::class, 'summary']);
    Route::get('history', [AttendanceController::class, 'history']);
    Route::get('days', [AttendanceController::class, 'days']);
    Route::post('daily-reports', [AttendanceController::class, 'saveDailyReport']);
});
