<?php
namespace Modules\Setting\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Trait\ResponseTrait;
use Modules\About\app\Services\AboutPageService;
use Modules\About\Http\Resources\AboutPageResource;
use Modules\Catalog\app\Services\CategoryService as CatalogCategoryService;
use Modules\Catalog\app\Services\ServiceService as CatalogServiceService;
use Modules\Catalog\Http\Resources\CategoryResource as CatalogCategoryResource;
use Modules\Catalog\Http\Resources\ServiceResource as CatalogServiceResource;
use Modules\Faq\app\Services\FaqService;
use Modules\Faq\Http\Resources\FaqListResource;
use Modules\Faq\Http\Resources\FaqSectionResource;
use Modules\ServiceFlow\app\Services\ServiceFlowService;
use Modules\ServiceFlow\Http\Resources\ServiceFlowResource;
use Modules\Slider\app\Services\SliderService;
use Modules\Slider\Http\Resources\SliderResource;

class HomeController extends Controller
{
    use ResponseTrait;

    protected SliderService $sliderService;
    protected AboutPageService $aboutPageService;
    protected ServiceFlowService $serviceFlowService;
    protected FaqService $faqService;
    protected CatalogCategoryService $catalogCategoryService;
    protected CatalogServiceService $catalogServiceService;

    public function __construct(
        SliderService $sliderService,
        AboutPageService $aboutPageService,
        ServiceFlowService $serviceFlowService,
        FaqService $faqService,
        CatalogCategoryService $catalogCategoryService,
        CatalogServiceService $catalogServiceService,
    ) {
        $this->sliderService          = $sliderService;
        $this->aboutPageService       = $aboutPageService;
        $this->serviceFlowService     = $serviceFlowService;
        $this->faqService             = $faqService;
        $this->catalogCategoryService = $catalogCategoryService;
        $this->catalogServiceService  = $catalogServiceService;
    }

    /**
     * Home Endpoint
     */
    public function home()
    {
        try {

            // Sliders
            $sliders = SliderResource::collection(
                $this->sliderService->listActive()
            );

            // About Page
            $aboutPage         = $this->aboutPageService->getActive();
            $aboutPageResource = $aboutPage ? new AboutPageResource($aboutPage) : null;

            // Service Flow
            $flows = ServiceFlowResource::collection(
                $this->serviceFlowService->listActiveSteps()
            );

            $faqIntro         = $this->faqService->getIntro();
            $faqIntroResource = $faqIntro ? new FaqSectionResource($faqIntro) : null;
            $faqItems         = FaqListResource::collection(
                $this->faqService->listActiveItems()
            );

            $categories = CatalogCategoryResource::collection(
                $this->catalogCategoryService->listActive()
            );

            $services = CatalogServiceResource::collection(
                $this->catalogServiceService->listActive(9)
            );

            return self::successResponse(
                message: __('Home data loaded successfully'),
                data: [
                    'sliders'      => $sliders,
                    'about_page'   => $aboutPageResource,
                    'service_flow' => $flows,
                    'faq_intro'    => $faqIntroResource,
                    'faq_items'    => $faqItems,
                    'categories'   => $categories,
                    'services'     => $services,
                ]
            );

        } catch (\Exception $e) {

            return self::failResponse(
                500,
                __('Something went wrong'),
                $e->getMessage() // optional remove if you don’t want show error
            );
        }
    }
}
