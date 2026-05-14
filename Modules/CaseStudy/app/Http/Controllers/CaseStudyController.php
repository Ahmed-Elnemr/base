<?php

namespace Modules\CaseStudy\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Trait\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\CaseStudy\app\Models\CaseStudy;
use Modules\CaseStudy\Http\Resources\CaseStudyResource;

class CaseStudyController extends Controller
{
    use ResponseTrait;

    public function index(Request $request): JsonResponse
    {
        $caseStudies = CaseStudy::query()
            ->active()
            ->latest()
            ->paginate($request->get('per_page', 10));

        return self::successResponse(
            message: __('Case studies loaded successfully'),
            data: CaseStudyResource::collection($caseStudies)->response()->getData(true)
        );
    }

    public function show(string $slug): JsonResponse
    {
        $caseStudy = CaseStudy::query()
            ->active()
            ->where('slug', $slug)
            ->first();

        if (! $caseStudy) {
            return self::failResponse(404, __('Case study not found'));
        }

        return self::successResponse(
            message: __('Case study loaded successfully'),
            data: new CaseStudyResource($caseStudy)
        );
    }
}
