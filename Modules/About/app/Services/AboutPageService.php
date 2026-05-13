<?php

namespace Modules\About\app\Services;

use Modules\About\app\Models\AboutPage;

class AboutPageService
{
    public function __construct(private readonly AboutPage $aboutPage)
    {
    }

    public function getActive(): ?AboutPage
    {
        return $this->aboutPage->newQuery()
            ->active()
            ->latest('updated_at')
            ->with('media')
            ->first();
    }
}










