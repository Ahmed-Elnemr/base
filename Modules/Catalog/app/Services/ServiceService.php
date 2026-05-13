<?php

namespace Modules\Catalog\app\Services;

use Illuminate\Support\Collection;
use Modules\Catalog\app\Models\Service;

class ServiceService
{
    public function __construct(private readonly Service $service)
    {
    }

    public function listActive(?int $limit = null): Collection
    {
        $query = $this->service->newQuery()
            ->with(['category', 'media'])
            ->active()
            ->orderBy('sort_order');

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    public function find(int $id): ?Service
    {
        return $this->service->newQuery()
            ->with(['category', 'media'])
            ->active()
            ->find($id);
    }
}








