<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Trait\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Blog\app\Services\BlogPostService;
use Modules\Blog\Http\Resources\BlogPostDetailResource;
use Modules\Blog\Http\Resources\BlogPostListResource;

class BlogPostController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly BlogPostService $blogPostService) {}

    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->get('per_page', 15);
        $posts = $this->blogPostService->listActive($perPage);

        return self::successResponse(
            message: __('Blog posts loaded successfully'),
            data: BlogPostListResource::collection($posts)->response()->getData(true),
        );
    }

    public function show(string $slug): JsonResponse
    {
        $post = $this->blogPostService->findBySlug($slug);

        if (! $post) {
            return self::failResponse(404, __('Blog post not found'));
        }

        return self::successResponse(
            message: __('Blog post loaded successfully'),
            data: new BlogPostDetailResource($post),
        );
    }
}
