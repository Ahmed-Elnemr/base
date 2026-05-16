<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Service\app\Models\ServiceCategory;

class CategoriesChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 1;

    public function getHeading(): string
    {
        return __('Services by Category');
    }

    protected function getData(): array
    {
        $data = ServiceCategory::withCount('services')->get();

        return [
            'datasets' => [
                [
                    'label' => __('Services'),
                    'data' => $data->pluck('services_count')->toArray(),
                    'backgroundColor' => [
                        '#ED6F31',
                        '#10B981',
                        '#3B82F6',
                        '#F59E0B',
                        '#8B5CF6',
                        '#EC4899',
                    ],
                ],
            ],
            'labels' => $data->map(fn ($item) => $item->getTranslation('name', app()->getLocale()))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
