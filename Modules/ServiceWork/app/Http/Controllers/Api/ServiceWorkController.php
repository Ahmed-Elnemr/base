<?php

namespace Modules\ServiceWork\app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Trait\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Modules\ServiceWork\app\Http\Resources\ServiceWorkItemResource;
use Modules\ServiceWork\app\Models\ServiceWorkCategory;

class ServiceWorkController extends Controller
{
    use ResponseTrait;

    public function show(string $slug): JsonResponse
    {
        $category = ServiceWorkCategory::query()
            ->active()
            ->where('slug', $slug)
            ->first();

        if (! $category) {
            return self::errorResponse(
                message: __('Category not found'),
                statusCode: 404
            );
        }

        $locale = app()->getLocale();

        $items = $category->items()
            ->active()
            ->orderBy('sort_order')
            ->paginate(40);

        return self::successResponse(
            message: __('Service works loaded successfully'),
            data: [
                'category' => [
                    'id' => $category->id,
                    'name' => $category->getTranslation('name', $locale),
                    'slug' => $category->slug,
                ],
                'works' => ServiceWorkItemResource::collection($items)->response()->getData(true),
            ]
        );
    }
}
