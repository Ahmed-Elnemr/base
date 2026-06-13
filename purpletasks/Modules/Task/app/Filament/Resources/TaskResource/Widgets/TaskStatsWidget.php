<?php

namespace Modules\Task\Filament\Resources\TaskResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Task\app\Models\Task;
use Illuminate\Support\Carbon;

class TaskStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('Total Tasks'), Task::count())
                ->description(__('All project tasks'))
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('primary'),

            Stat::make(__('Completed Tasks'), Task::where('status', 'completed')->count())
                ->description(__('Tasks marked as done'))
                ->descriptionIcon('heroicon-m-check-circle')
                ->chart([2, 5, 4, 6, 8, 3, 9])
                ->color('success'),

            Stat::make(__('Pending Tasks'), Task::where('status', 'pending')->count())
                ->description(__('Tasks awaiting action'))
                ->descriptionIcon('heroicon-m-clock')
                ->chart([1, 0, 2, 3, 5, 2, 7])
                ->color('warning'),
        ];
    }
}
