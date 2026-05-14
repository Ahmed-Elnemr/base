<?php

namespace Modules\Portfolio\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Trait\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Portfolio\app\Models\Work;
use Modules\Portfolio\Http\Resources\WorkResource;

class WorkController extends Controller
{
    use ResponseTrait;

    public function index(Request $request): JsonResponse
    {
        $works = Work::query()
            ->active()
            ->orderBy('sort_order')
            ->paginate($request->get('per_page', 12));

        return self::successResponse(
            message: __('Works loaded successfully'),
            data: WorkResource::collection($works)->response()->getData(true)
        );
    }
}
