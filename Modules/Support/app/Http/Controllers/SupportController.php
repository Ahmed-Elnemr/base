<?php
namespace Modules\Support\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Trait\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Modules\Support\app\Services\SupportCenterService;
use Modules\Support\Http\Requests\SupportMessageRequest;
use Modules\Support\Http\Resources\SupportMessageResource;
use Modules\Support\Http\Resources\SupportPageResource;

class SupportController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly SupportCenterService $supportCenterService)
    {}

    public function show(): JsonResponse
    {
        $page = $this->supportCenterService->getActivePage();

        return self::successResponse(
            message: __('Support center loaded successfully'),
            data: [
                'page'          => $page ? new SupportPageResource($page) : null,
                'message_types' => $this->supportCenterService->messageTypes(),
            ]
        );
    }

    public function store(SupportMessageRequest $request): JsonResponse
    {
        $payload = $request->safe()->except(['image']);

        $message = $this->supportCenterService->persistMessage($payload);

        if ($request->hasFile('image')) {
            $message->addMediaFromRequest('image')
                ->toMediaCollection('support_message_image');
        }

        return self::successResponse(
            message: __('Your message has been received'),
            data: new SupportMessageResource($message),
            statusCode: 201
        );
    }
}
