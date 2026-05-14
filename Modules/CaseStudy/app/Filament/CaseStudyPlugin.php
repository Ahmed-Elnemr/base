<?php

namespace Modules\CaseStudy\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class CaseStudyPlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'CaseStudy';
    }

    public function getId(): string
    {
        return 'case-study';
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
