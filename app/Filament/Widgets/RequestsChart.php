<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Project\app\Models\ProjectRequest;
use Carbon\Carbon;

class RequestsChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 1;

    protected ?string $heading = 'Project Requests Trend';

    public function getHeading(): string
    {
        return __('Project Requests Trend');
    }

    protected function getData(): array
    {
        $data = ProjectRequest::selectRaw('COUNT(*) as count, DATE_FORMAT(created_at, "%Y-%m") as month')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => __('New Requests'),
                    'data' => $data->pluck('count')->toArray(),
                    'fill' => 'start',
                    'borderColor' => '#ED6F31',
                    'backgroundColor' => 'rgba(237, 111, 49, 0.1)',
                ],
            ],
            'labels' => $data->map(fn ($item) => Carbon::parse($item->month)->format('M Y'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
