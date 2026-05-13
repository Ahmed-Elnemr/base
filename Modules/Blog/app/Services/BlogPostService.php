<?php

namespace Modules\Blog\app\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Blog\app\Models\BlogPost;

class BlogPostService
{
    public function __construct(private readonly BlogPost $blogPost) {}

    public function listActive(int $perPage = 15): LengthAwarePaginator
    {
        return $this->blogPost->newQuery()
            ->active()
            ->with('media')
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function findBySlug(string $slug): ?BlogPost
    {
        return $this->blogPost->newQuery()
            ->active()
            ->where('slug', $slug)
            ->with('media')
            ->first();
    }
}
