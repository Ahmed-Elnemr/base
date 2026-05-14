<?php

namespace Modules\Portfolio\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class PortfolioPlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'Portfolio';
    }

    public function getId(): string
    {
        return 'portfolio';
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
