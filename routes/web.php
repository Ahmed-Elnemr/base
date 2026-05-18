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
        return 'Error: ' . $e->getMessage();
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
        return 'Error: ' . $e->getMessage();
    }
});

Route::get('/run-assets', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('filament:assets');

        return 'Filament assets published successfully!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

Route::get('/run-permissions', function () {
    try {
        $storagePath = storage_path('app/public');

        // Set directories to 755 and files to 644
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($storagePath, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        $fixed = 0;
        foreach ($iterator as $item) {
            if ($item->isDir()) {
                chmod($item->getPathname(), 0755);
            } else {
                chmod($item->getPathname(), 0644);
            }
            $fixed++;
        }

        chmod($storagePath, 0755);

        return "Permissions fixed! ({$fixed} items updated)";
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});
