<?php

namespace Modules\ServiceWork\app\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class ServiceWorkPlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'ServiceWork';
    }

    public function getId(): string
    {
        return 'servicework';
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
