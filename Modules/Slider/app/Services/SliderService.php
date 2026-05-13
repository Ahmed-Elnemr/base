<?php

namespace Modules\Slider\app\Services;

use Illuminate\Support\Collection;
use Modules\Slider\app\Models\Slider;

class SliderService
{
    public function __construct(private readonly Slider $slider)
    {
    }

    public function listActive(): Collection
    {
        return $this->slider->newQuery()
            ->active()
            ->with('media')
            ->get();
    }
}










