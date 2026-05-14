<?php

use Filament\Facades\Filament;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

foreach (Filament::getPanels() as $panel) {
    echo 'Panel: ' . $panel->getId() . PHP_EOL;
    foreach ($panel->getResources() as $resource) {
        echo ' - ' . $resource . PHP_EOL;
    }
}
