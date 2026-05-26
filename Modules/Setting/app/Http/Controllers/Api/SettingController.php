<?php

namespace Modules\Setting\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Trait\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Modules\Setting\app\Models\GeneralSetting;
use Modules\Service\app\Models\ServiceCategory;

class SettingController extends Controller
{
    use ResponseTrait;

    public function settings(): JsonResponse
    {
        $locale = app()->getLocale();
        $settings = GeneralSetting::first();
        $categories = ServiceCategory::active()
            ->with(['services' => fn($q) => $q->active()->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get();

        return self::successResponse(
            message: __('Settings loaded successfully'),
            data: [
                'contact' => $settings ? [
                    'address' => $settings->getTranslation('address', $locale),
                    'email' => $settings->email,
                    'phone' => $settings->phone,
                    'social_links' => $settings->social_links,
                ] : null,
                'logos' => $settings ? [
                    'header' => $settings->getFirstMediaUrl('logo_header') ? url($settings->getFirstMediaUrl('logo_header')) : null,
                    'footer' => $settings->getFirstMediaUrl('logo_footer') ? url($settings->getFirstMediaUrl('logo_footer')) : null,
                ] : null,
                'occasions' => ($settings && $settings->occasion_is_active) ? [
                    'title' => $settings->getTranslation('occasion_title', $locale),
                    'content' => $settings->getTranslation('occasion_content', $locale),
                    'image' => $settings->getFirstMediaUrl('occasion_image') ? url($settings->getFirstMediaUrl('occasion_image')) : null,
                ] : null,
                'categories' => $categories->map(fn($cat) => [
                    'id' => $cat->id,
                    'name' => $cat->getTranslation('name', $locale),
                    'services' => $cat->services->map(fn($service) => [
                        'id' => $service->id,
                        'title' => $service->getTranslation('title', $locale),
                        'slug' => $service->slug,
                    ]),
                ]),
            ]
        );
    }
}
