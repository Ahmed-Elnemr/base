<?php

namespace Modules\Catalog\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\ServiceViewedNotification;
use App\Trait\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Modules\Catalog\app\Models\Service;
use Modules\Catalog\app\Services\ServiceService;
use Modules\Catalog\Http\Requests\StoreServiceRequest;
use Modules\Catalog\Http\Requests\UpdateServiceRequest;
use Modules\Catalog\Http\Resources\ServiceResource;
use Modules\Catalog\Http\Resources\ServiceDetailResource;

class ServiceApiController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly ServiceService $serviceService)
    {
    }

    public function index(): JsonResponse
    {
        $limit = request()->integer('limit');

        return self::successResponse(
            message: __('Services loaded successfully'),
            data: ServiceResource::collection($this->serviceService->listActive($limit))
        );
    }

    public function show(int $service): JsonResponse
    {
        $service = $this->serviceService->find($service);

        if (! $service) {
            return self::failResponse(404, __('Service not found'));
        }

        // إرسال إشعار للإدارة إذا كان المستخدم مسجل دخول
        if (auth()->check()) {
            $user = auth()->user();
            $admins = User::where('client_type', 'admin')->get();
            
            if ($admins->isNotEmpty()) {
                $serviceTitle = is_array($service->title) 
                    ? ($service->title[app()->getLocale()] ?? $service->title['ar'] ?? 'Unknown')
                    : $service->title;
                    
                Notification::send($admins, new ServiceViewedNotification(
                    $user,
                    $service->id,
                    $serviceTitle
                ));
            }
        }

        return self::successResponse(
            message: __('Service loaded successfully'),
            data: new ServiceDetailResource($service)
        );
    }


    public function store(StoreServiceRequest $request)
    {
        try {
            DB::beginTransaction();

            $service = Service::create([
                'catalog_category_id' => $request->catalog_category_id,
                'user_id'             => auth()->id(),
                'title'               => $request->title,
                'content'             => $request->content,
                'features'            => collect($request->features)->map(function($feature) {
                    return ['value' => $feature];
                })->toArray(),
                'price'               => $request->price,
                'phone'               => $request->phone,
                'mobile'               => $request->mobile,
            ]);

            // Media Upload (Gallery)
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $service
                        ->addMedia($image)
                        ->toMediaCollection('service_gallery');
                }
            }

            DB::commit();

            return self::successResponse(
                message:__('Service created successfully'),
                data: $service->load('media'),
               statusCode: 201
            );

        } catch (\Throwable $e) {
            DB::rollBack();

            return self::failResponse(
                500,
                $e->getMessage()
            );
        }
    }


    public function myServices(): JsonResponse
    {
        $user = auth()->user();

        if ($user->client_type !== \App\Models\User::CLIENT_TYPE_COMPANY) {
            return self::failResponse(
                403,
                __('Only company accounts can view their services')
            );
        }

        $services = Service::query()
            ->where('user_id', $user->id)
            ->with('media')
            ->latest()
            ->get();

        return self::successResponse(
            message: __('Services loaded successfully'),
            data: ServiceResource::collection($services)
        );
    }


    public function destroy(int $id): JsonResponse
    {
        try {
            $user = auth()->user();

            $service = Service::where('id', $id)
                ->where('user_id', $user->id)
                ->first();

            if (! $service) {
                return self::failResponse(
                    404,
                    __('Service not found or you are not authorized to delete it')
                );
            }

            DB::beginTransaction();

            // Delete media first (optional but recommended)
            $service->clearMediaCollection('service_gallery');

            $service->delete();

            DB::commit();

            return self::successResponse(
                message: __('Service deleted successfully')
            );

        } catch (\Throwable $e) {
            DB::rollBack();

            return self::failResponse(
                500,
                $e->getMessage()
            );
        }
    }



    public function update(UpdateServiceRequest $request, int $id): JsonResponse
    {
        try {
            $user = auth()->user();

            $service = Service::where('id', $id)
                ->where('user_id', $user->id)
                ->first();

            if (! $service) {
                return self::failResponse(
                    404,
                    __('Service not found or you are not authorized to update it')
                );
            }

            DB::beginTransaction();

            $service->fill([
                'catalog_category_id' => $request->catalog_category_id,
                'price'  => $request->price,
                'phone'  => $request->phone,
                'mobile' => $request->mobile,
            ]);

            if ($request->has('title')) {
                foreach ($request->title as $lang => $value) {
                    if ($value) {
                        $service->setTranslation('title', $lang, $value);
                    }
                }
            }

            if ($request->has('content')) {
                foreach ($request->content as $lang => $value) {
                    if ($value) {
                        $service->setTranslation('content', $lang, $value);
                    }
                }
            }

            $service->features = collect($request->features)->map(fn ($f) => [
                'value' => $f
            ])->toArray();

            $service->save();

            if ($request->hasFile('images')) {
                $service->clearMediaCollection('service_gallery');

                foreach ($request->file('images') as $image) {
                    $service
                        ->addMedia($image)
                        ->toMediaCollection('service_gallery');
                }
            }

            DB::commit();

            return self::successResponse(
                message: __('Service updated successfully'),
                data: $service->load('media')
            );

        } catch (\Throwable $e) {
            DB::rollBack();

            return self::failResponse(
                500,
                $e->getMessage()
            );
        }
    }



}

