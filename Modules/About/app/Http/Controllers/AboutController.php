<?php
namespace Modules\About\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Trait\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Modules\About\app\Services\AboutPageService;
use Modules\About\Http\Resources\AboutPageResource;

class AboutController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly AboutPageService $aboutPageService)
    {
    }

    public function __invoke(): JsonResponse
    {
        $page = $this->aboutPageService->getActive();

        if (! $page) {
            return self::failResponse(404, __('About page is not available yet'));
        }

        return self::successResponse(
            message: __('About page loaded successfully'),
            data: new AboutPageResource($page)
        );
    }
}
