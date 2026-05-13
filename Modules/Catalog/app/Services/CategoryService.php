<?php

namespace Modules\Catalog\app\Services;

use Illuminate\Support\Collection;
use Modules\Catalog\app\Models\Category;

class CategoryService
{
    public function __construct(private readonly Category $category)
    {
    }

    public function listActive(): Collection
    {
        return $this->category->newQuery()
            ->with('media')
            ->active()
            ->orderBy('sort_order')
            ->get();
    }

    public function findWithServices(int $id): ?Category
    {
        return $this->category->newQuery()
            ->with([
                'services' => fn ($query) => $query->active()->with('media')->orderBy('sort_order'),
                'media',
            ])
            ->active()
            ->find($id);
    }
}








