<?php

namespace Modules\Home\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Trait\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Modules\Home\app\Models\HeroSection;
use Modules\Home\app\Models\HomeStat;
use Modules\Home\app\Models\Partner;
use Modules\Home\app\Models\WhyUsSection;
use Modules\Home\app\Models\WorkMethodSection;
use Modules\Home\app\Models\CTASection;
use Modules\Service\app\Models\Service;
use Modules\Portfolio\app\Models\Work;

class HomeController extends Controller
{
    use ResponseTrait;

    public function home(): JsonResponse
    {
        $locale = app()->getLocale();

        $hero = HeroSection::first();
        $whyUs = WhyUsSection::first();
        $workMethod = WorkMethodSection::first();
        $cta = CTASection::first();
        $partners = Partner::active()->orderBy('sort_order')->get();
        $stats = HomeStat::active()->orderBy('sort_order')->get();
        $services = Service::active()->orderBy('sort_order')->take(4)->get();
        $portfolio = Work::active()->orderBy('sort_order')->take(6)->get();

        return self::successResponse(
            message: __('Home data loaded successfully'),
            data: [
                'hero' => $hero ? [
                    'title' => $hero->getTranslation('title', $locale),
                    'subtitle' => $hero->getTranslation('subtitle', $locale),
                    'button_1' => [
                        'text' => $hero->getTranslation('button_text_1', $locale),
                        'url' => $hero->button_url_1,
                    ],
                    'button_2' => [
                        'text' => $hero->getTranslation('button_text_2', $locale),
                        'url' => $hero->button_url_2,
                    ],
                    'image' => $hero->getFirstMediaUrl('hero_image'),
                ] : null,
                'stats' => $stats->map(fn($stat) => [
                    'title' => $stat->getTranslation('title', $locale),
                    'value' => $stat->value,
                ]),
                'services_section' => [
                    'title' => __('Everything you need for your brand'),
                    'items' => $services->map(fn($service) => [
                        'id' => $service->id,
                        'title' => $service->getTranslation('title', $locale),
                        'slug' => $service->slug,
                        'image' => $service->getFirstMediaUrl('service_image'),
                    ]),
                ],
                'partners' => $partners->map(fn($partner) => [
                    'name' => $partner->name,
                    'logo' => $partner->getFirstMediaUrl('logo'),
                ]),
                'why_us' => $whyUs ? [
                    'title' => $whyUs->getTranslation('title', $locale),
                    'content' => $whyUs->getTranslation('content', $locale),
                    'points' => $whyUs->getTranslation('points', $locale) ?? [],
                    'image' => $whyUs->getFirstMediaUrl('why_us_image'),
                ] : null,
                'work_method' => $workMethod ? [
                    'title' => $workMethod->getTranslation('title', $locale),
                    'steps' => $workMethod->getTranslation('steps', $locale) ?? [],
                ] : null,
                'portfolio_section' => [
                    'title' => __('Examples of our creative direction'),
                    'items' => $portfolio->map(fn($work) => [
                        'id' => $work->id,
                        'title' => $work->getTranslation('title', $locale),
                        'subtitle' => $work->getTranslation('subtitle', $locale),
                        'type' => $work->type,
                        'thumbnail' => $work->getFirstMediaUrl('work_thumbnail'),
                    ]),
                ],
                'cta_section' => $cta ? [
                    'title' => $cta->getTranslation('title', $locale),
                    'subtitle' => $cta->getTranslation('subtitle', $locale),
                    'button' => [
                        'text' => $cta->getTranslation('button_text', $locale),
                        'url' => $cta->button_url,
                    ],
                ] : null,
            ]
        );
    }
}
