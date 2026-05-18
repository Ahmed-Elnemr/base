<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\CaseStudy\app\Models\CaseStudy;
use Modules\CaseStudy\Filament\Resources\CaseStudy\CaseStudyResource;
use Modules\Portfolio\app\Models\Work;
use Modules\Portfolio\Filament\Resources\Work\WorkResource;
use Modules\Project\app\Models\ProjectRequest;
use Modules\Project\Filament\Resources\ProjectRequest\ProjectRequestResource;
use Modules\Service\app\Models\Service;
use Modules\Service\Filament\Resources\Service\ServiceResource;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    protected function getCreativeTrend(int $finalCount): array
    {
        if ($finalCount === 0) {
            return [0, 0, 0, 0, 0, 0, 0];
        }

        $points = [];
        $points[] = max(0, (int) round($finalCount * 0.2));
        $points[] = max(0, (int) round($finalCount * 0.5));
        $points[] = max(0, (int) round($finalCount * 0.3));
        $points[] = max(0, (int) round($finalCount * 0.8));
        $points[] = max(0, (int) round($finalCount * 0.4));
        $points[] = max(0, (int) round($finalCount * 0.9));
        $points[] = $finalCount;

        return $points;
    }

    protected function getStats(): array
    {
        $servicesCount = Service::count();
        $portfolioCount = Work::count();
        $caseStudiesCount = CaseStudy::count();
        $projectRequestsCount = ProjectRequest::count();

        return [
            Stat::make(__('Services'), $servicesCount)
                ->description(__('Total active services'))
                ->descriptionIcon('heroicon-m-sparkles')
                ->chart($this->getCreativeTrend($servicesCount))
                ->color('success')
                ->url(ServiceResource::getUrl()),

            Stat::make(__('Portfolio'), $portfolioCount)
                ->description(__('Completed works in gallery'))
                ->descriptionIcon('heroicon-m-photo')
                ->chart($this->getCreativeTrend($portfolioCount))
                ->color('info')
                ->url(WorkResource::getUrl()),

            Stat::make(__('Case Studies'), $caseStudiesCount)
                ->description(__('Published success stories'))
                ->descriptionIcon('heroicon-m-briefcase')
                ->chart($this->getCreativeTrend($caseStudiesCount))
                ->color('warning')
                ->url(CaseStudyResource::getUrl()),

            Stat::make(__('Project Requests'), $projectRequestsCount)
                ->description(__('Pending and new requests'))
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->chart($this->getCreativeTrend($projectRequestsCount))
                ->color('danger')
                ->url(ProjectRequestResource::getUrl()),
        ];
    }
}
