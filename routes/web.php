<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('admin');
});

Route::post('/support/messages', [HomeController::class, 'submitSupport'])
    ->name('support.message.store');

$secretKey = 'nemr123';

Route::get('/test', function () {
    return 'test';
});

Route::get('/run-link/{key}', function ($key) use ($secretKey) {

    abort_if($key !== $secretKey, 403);

    try {
        Artisan::call('storage:link');

        return 'Storage link created successfully!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

Route::get('/run-clear/{key}', function ($key) use ($secretKey) {

    abort_if($key !== $secretKey, 403);

    try {
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');

        return 'Cache, Config, Routes, and Views cleared successfully!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

Route::get('/run-assets/{key}', function ($key) use ($secretKey) {

    abort_if($key !== $secretKey, 403);

    try {
        Artisan::call('filament:assets');

        return 'Filament assets published successfully!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

Route::get('/run-permissions/{key}', function ($key) use ($secretKey) {

    abort_if($key !== $secretKey, 403);

    try {

        $storagePath = storage_path('app/public');

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(
                $storagePath,
                RecursiveDirectoryIterator::SKIP_DOTS
            ),
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

Route::get('/run-migrate/{key}', function ($key) use ($secretKey) {

    abort_if($key !== $secretKey, 403);

    try {

        Artisan::call('migrate', [
            '--force' => true
        ]);

        return nl2br(Artisan::output());

    } catch (\Exception $e) {

        return 'Error: ' . $e->getMessage();
    }
});

Route::get('/run-dump-autoload/{key}', function ($key) use ($secretKey) {

    abort_if($key !== $secretKey, 403);

    try {

        Artisan::call('optimize:clear');

        $output = shell_exec('composer dump-autoload');

        return nl2br($output ?: 'Composer dump-autoload executed successfully.');

    } catch (\Exception $e) {

        return 'Error: ' . $e->getMessage();
    }
});
Route::get('/run-seeder-work/{key}', function ($key) use ($secretKey) {

    abort_if($key !== $secretKey, 403);

    try {

        Artisan::call('db:seed', [
            '--class' => 'Database\\Seeders\\ServiceWorkDatabaseSeeder',
            '--force' => true,
        ]);

        return nl2br(Artisan::output());

    } catch (\Exception $e) {

        return 'Error: ' . $e->getMessage();
    }
});
