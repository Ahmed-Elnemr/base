<?php

namespace Modules\Home\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class HomePlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'Home';
    }

    public function getId(): string
    {
        return 'home';
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
