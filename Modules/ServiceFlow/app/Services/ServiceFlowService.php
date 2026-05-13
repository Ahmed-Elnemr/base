<?php

namespace Modules\ServiceFlow\app\Services;

use Illuminate\Support\Collection;
use Modules\ServiceFlow\app\Models\ServiceFlow;

class ServiceFlowService
{
    public function __construct(private readonly ServiceFlow $serviceFlow)
    {
    }

    public function listActiveSteps(): Collection
    {
        return $this->serviceFlow->newQuery()
            ->active()
            ->with('media')
            ->orderBy('step_number')
            ->orderBy('sort_order')
            ->get();
    }
}



