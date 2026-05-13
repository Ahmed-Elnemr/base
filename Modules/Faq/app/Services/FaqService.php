<?php

namespace Modules\Faq\app\Services;

use Illuminate\Support\Collection;
use Modules\Faq\app\Models\FaqItem;
use Modules\Faq\app\Models\FaqSection;

class FaqService
{
    public function __construct(
        private readonly FaqSection $section,
        private readonly FaqItem $item
    ) {
    }

    public function getIntro(): ?FaqSection
    {
        return $this->section->newQuery()->first();
    }

    public function listActiveItems(): Collection
    {
        return $this->item->newQuery()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }
}
