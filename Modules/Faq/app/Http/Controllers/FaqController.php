<?php

namespace Modules\Faq\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Trait\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Modules\Faq\app\Services\FaqService;
use Modules\Faq\Http\Resources\FaqSectionResource;
use Modules\Faq\Http\Resources\FaqListResource;

class FaqController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly FaqService $faqService)
    {
    }

    public function __invoke(): JsonResponse
    {
        $intro = $this->faqService->getIntro();
        $introResource = $intro ? new FaqSectionResource($intro) : null;
        $items = FaqListResource::collection($this->faqService->listActiveItems());

        return self::successResponse(
            message: __('FAQ loaded successfully'),
            data: [
                'intro' => $introResource,
                'items' => $items,
            ]
        );
    }
}
