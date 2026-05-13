<?php

namespace Modules\ServiceFlow\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Trait\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Modules\ServiceFlow\app\Services\ServiceFlowService;
use Modules\ServiceFlow\Http\Resources\ServiceFlowResource;

class ServiceFlowController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly ServiceFlowService $serviceFlowService)
    {
    }

    public function __invoke(): JsonResponse
    {
        $flows = ServiceFlowResource::collection(
            $this->serviceFlowService->listActiveSteps()
        );

        return self::successResponse(
            message: __('Service flow loaded successfully'),
            data: $flows
        );
    }
}
