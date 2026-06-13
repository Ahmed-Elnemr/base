<?php

$directories = [
    __DIR__ . '/../storage/framework/views',
    __DIR__ . '/../storage/framework/cache',
    __DIR__ . '/../storage/framework/sessions',
    __DIR__ . '/../bootstrap/cache',
];

foreach ($directories as $dir) {
    if (!file_exists($dir)) {
        mkdir($dir, 0775, true);
        echo "Created: $dir <br>";
    } else {
        echo "Already exists: $dir <br>";
    }
}

try {
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    
    $kernel->call('optimize:clear');
    echo "<br>Cache cleared successfully!<br>";
} catch (\Exception $e) {
    echo "<br>Could not clear cache via artisan, but folders were created. Error: " . $e->getMessage() . "<br>";
}

// إنشاء اختصار (Symlink) لمشروع purpletasks
$target = __DIR__ . '/../purpletasks/public';
$link = __DIR__ . '/tasks';

if (!file_exists($link)) {
    if (file_exists($target)) {
        symlink($target, $link);
        echo "<br>Symlink for 'tasks' created successfully!<br>";
    } else {
        echo "<br>Warning: 'purpletasks/public' directory does not exist, so symlink was not created.<br>";
    }
} else {
    echo "<br>'tasks' symlink already exists!<br>";
}

echo "<br><b>Done! You can now delete this file and visit your website.</b>";

