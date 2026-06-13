<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Task\app\Models\Task;

class TasksChartWidget extends ChartWidget
{
    protected static ?int $sort = 2;

    public function getHeading(): string
    {
        return __('Project Tasks');
    }

    protected function getData(): array
    {
        $pending = Task::where('status', 'pending')->count();
        $inProgress = Task::where('status', 'in_progress')->count();
        $completed = Task::where('status', 'completed')->count();

        return [
            'datasets' => [
                [
                    'label' => __('Tasks'),
                    'data' => [$pending, $inProgress, $completed],
                    'backgroundColor' => ['#f59e0b', '#3b82f6', '#10b981'],
                ],
            ],
            'labels' => [__('Pending'), __('In Progress'), __('Completed')],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
