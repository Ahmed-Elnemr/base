<?php
namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\About\app\Models\AboutPage;
use Modules\Catalog\app\Models\Category as CatalogCategory;
use Modules\Catalog\app\Models\Service as CatalogService;
use Modules\Faq\app\Models\FaqItem;
use Modules\Faq\app\Models\FaqSection;
use Modules\ServiceFlow\app\Models\ServiceFlow;
use Modules\Slider\app\Models\Slider;
use Modules\Support\app\Models\SupportPage;
use Modules\Support\app\Services\SupportCenterService;
use Modules\Support\Http\Requests\SupportMessageRequest;

class HomeController extends Controller
{
    public function index(): View
    {
        $sliders = Slider::query()
            ->active()
            ->with('media')
            ->orderBy('sort_order')
            ->get();

        $about = AboutPage::query()
            ->active()
            ->with('media')
            ->latest('updated_at')
            ->first();

        $serviceSteps = ServiceFlow::query()
            ->active()
            ->with('media')
            ->orderBy('sort_order')
            ->orderBy('step_number')
            ->get();

        $sections = CatalogCategory::query()
            ->active()
            ->with('media')
            ->orderBy('sort_order')
            ->get();

        $services = CatalogService::query()
            ->active()
            ->with(['category', 'media'])
            ->orderBy('sort_order')
            ->limit(9)
            ->get();

        $faqIntro = FaqSection::query()->first();
        $faqItems = FaqItem::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $supportPage = SupportPage::query()
            ->active()
            ->with('media')
            ->latest('updated_at')
            ->first();

        $supportTypes = app(SupportCenterService::class)->messageTypes();

        return view('home', compact(
            'sliders',
            'about',
            'serviceSteps',
            'faqIntro',
            'faqItems',
            'supportPage',
            'supportTypes',
            'sections',
            'services'
        ));
    }

    public function submitSupport(
        SupportMessageRequest $request,
        SupportCenterService $supportCenterService
    ): RedirectResponse {
        $message = $supportCenterService->persistMessage($request->validated());

        return back()->with([
            'support_submitted' => true,
            'support_receipt'   => $message->id,
        ]);
    }
}
