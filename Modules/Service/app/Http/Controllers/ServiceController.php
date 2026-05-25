<?php

namespace Modules\Service\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Trait\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Service\app\Models\Service;
use Modules\Service\app\Models\ServiceCategory;
use Modules\Service\Http\Resources\ServiceCategoryResource;
use Modules\Service\Http\Resources\ServiceResource;

class ServiceController extends Controller
{
    use ResponseTrait;

    public function index(): JsonResponse
    {
        $categories = ServiceCategory::query()
            ->active()
            ->with(['services' => fn ($q) => $q->active()->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get();

        return self::successResponse(
            message: __('Service categories loaded successfully'),
            data: ServiceCategoryResource::collection($categories)
        );
    }

    public function list(Request $request): JsonResponse
    {
        $services = Service::query()
            ->active()
            ->with(['category'])
            ->orderBy('sort_order')
            ->paginate($request->get('per_page', 12));

        return self::successResponse(
            message: __('Services loaded successfully'),
            data: ServiceResource::collection($services)->response()->getData(true)
        );
    }

    public function show(string $slug): JsonResponse
    {
        $service = Service::query()
            ->where('slug', $slug)
            ->active()
            ->with(['category', 'similarServices'])
            ->first();

        if (! $service) {
            return self::failResponse(statusCode: 404, message: __('Service not found'));
        }

        return self::successResponse(
            message: __('Service loaded successfully'),
            data: new ServiceResource($service)
        );
    }
}
