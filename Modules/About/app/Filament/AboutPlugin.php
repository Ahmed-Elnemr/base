<?php

namespace Modules\About\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class AboutPlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'About';
    }

    public function getId(): string
    {
        return 'about';
    }

    public function boot(Panel $panel): void
    {
        //
    }
}










