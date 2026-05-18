<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Project\app\Models\ProjectRequest;

class RequestsChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 1;

    protected ?string $heading = 'Project Requests Trend';

    public function getHeading(): string
    {
        return __('Project Requests Trend');
    }

    protected function getData(): array
    {
        $months = [];
        $counts = [];

        for ($i = 5; $i >= 0; $i--) {
            $monthStart = now()->subMonths($i)->startOfMonth();
            $monthEnd = now()->subMonths($i)->endOfMonth();

            $count = ProjectRequest::query()
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->count();

            $months[] = now()->subMonths($i)->translatedFormat('F Y');
            $counts[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => __('New Requests'),
                    'data' => $counts,
                    'fill' => 'start',
                    'borderColor' => '#ED6F31',
                    'backgroundColor' => 'rgba(237, 111, 49, 0.1)',
                    'tension' => 0.4,
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
