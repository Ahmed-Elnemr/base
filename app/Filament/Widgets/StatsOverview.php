<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Service\app\Models\Service;
use Modules\Project\app\Models\ProjectRequest;
use Modules\Portfolio\app\Models\Work;
use Modules\CaseStudy\app\Models\CaseStudy;
use Modules\Service\Filament\Resources\Service\ServiceResource;
use Modules\Project\Filament\Resources\ProjectRequest\ProjectRequestResource;
use Modules\Portfolio\Filament\Resources\Work\WorkResource;
use Modules\CaseStudy\Filament\Resources\CaseStudy\CaseStudyResource;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make(__('Services'), Service::count())
                ->description(__('Total active services'))
                ->descriptionIcon('heroicon-m-sparkles')
                ->color('success')
                ->url(ServiceResource::getUrl()),

            Stat::make(__('Portfolio'), Work::count())
                ->description(__('Completed works in gallery'))
                ->descriptionIcon('heroicon-m-photo')
                ->color('info')
                ->url(WorkResource::getUrl()),

            Stat::make(__('Case Studies'), CaseStudy::count())
                ->description(__('Published success stories'))
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('warning')
                ->url(CaseStudyResource::getUrl()),

            Stat::make(__('Project Requests'), ProjectRequest::count())
                ->description(__('Pending and new requests'))
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('danger')
                ->url(ProjectRequestResource::getUrl()),
        ];
    }
}
