<?php

namespace Modules\Faq\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class FaqPlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'Faq';
    }

    public function getId(): string
    {
        return 'faq';
    }

    public function boot(Panel $panel): void
    {
        //
    }
}










