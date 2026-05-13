<?php

namespace Modules\Catalog\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Trait\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Modules\Catalog\app\Services\CategoryService;
use Modules\Catalog\Http\Resources\CategoryResource;
use Modules\Catalog\Http\Resources\CategoryWithServicesResource;

class CategoryApiController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly CategoryService $categoryService) {}

    public function index(): JsonResponse
    {
        return self::successResponse(
            message: __('Categories loaded successfully'),
            data: CategoryResource::collection($this->categoryService->listActive())
        );
    }

    public function show(int $category): JsonResponse
    {
        $category = $this->categoryService->findWithServices($category);

        if (! $category) {
            return self::failResponse(404, __('Category not found'));
        }

        return self::successResponse(
            message: __('Category loaded successfully'),
            data: new CategoryWithServicesResource($category)
        );
    }

    // public function services(int $category): JsonResponse
    // {
    //     $category = $this->categoryService->findWithServices($category);

    //     if (! $category) {
    //         return self::failResponse(404, __('Category not found'));
    //     }

    //     return self::successResponse(
    //         message: __('Services loaded successfully'),
    //         data: ServiceResource::collection($category->services)
    //     );

    // }

}
