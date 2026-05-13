<?php

namespace Modules\Support\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class SupportPlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'Support';
    }

    public function getId(): string
    {
        return 'support';
    }

    public function boot(Panel $panel): void
    {
        //
    }
}










