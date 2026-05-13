<?php

namespace Modules\ServiceFlow\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class ServiceFlowPlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'ServiceFlow';
    }

    public function getId(): string
    {
        return 'service-flow';
    }

    public function boot(Panel $panel): void
    {
        //
    }
}










