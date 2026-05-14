<?php

namespace Modules\Project\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Trait\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Modules\Project\app\Models\ProjectRequest;
use Modules\Project\Http\Requests\StoreProjectRequest;
use Modules\Service\app\Models\Service;

class ProjectController extends Controller
{
    use ResponseTrait;

    public function submit(StoreProjectRequest $request): JsonResponse
    {
        $projectRequest = ProjectRequest::create($request->validated());

        return self::successResponse(
            message: __('Your project request has been sent successfully. We will contact you soon.'),
            data: $projectRequest
        );
    }

    public function services(): JsonResponse
    {
        $locale = app()->getLocale();
        $services = Service::query()
            ->active()
            ->get(['id', 'title'])
            ->map(fn ($service) => [
                'id' => $service->id,
                'name' => $service->getTranslation('title', $locale),
            ]);

        return self::successResponse(
            message: __('Services loaded successfully'),
            data: $services
        );
    }
}
