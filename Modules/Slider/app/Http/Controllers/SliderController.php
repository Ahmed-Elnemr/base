<?php
namespace Modules\Slider\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Trait\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Modules\Slider\app\Services\SliderService;
use Modules\Slider\Http\Resources\SliderResource;

class SliderController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly SliderService $sliderService)
    {
    }

    public function __invoke(): JsonResponse
    {
        $sliders = SliderResource::collection(
            $this->sliderService->listActive()
        );

        return self::successResponse(
            message: __('Sliders loaded successfully'),
            data: $sliders
        );
    }
}
