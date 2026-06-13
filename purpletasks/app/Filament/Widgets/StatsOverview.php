<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Attendance\app\Models\Attendance;
use Modules\Task\app\Models\Task;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $usersCount = User::count();
        $todayAttendances = Attendance::where('date', today())->where('status', 'active')->count();
        $pendingTasks = Task::where('status', 'pending')->count();
        $completedTasksToday = Task::where('status', 'completed')
            ->whereDate('updated_at', today())
            ->count();

        return [
            Stat::make(__('Total Users'), $usersCount)
                ->description(__('Registered employees'))
                ->descriptionIcon('heroicon-m-users')
                ->color('primary')
                ->url(\App\Filament\Resources\UserResource::getUrl()),

            Stat::make(__('Active Now'), $todayAttendances)
                ->description(__('Clocked in today'))
                ->descriptionIcon('heroicon-m-clock')
                ->color('success')
                ->url(\Modules\Attendance\Filament\Resources\AttendanceResource::getUrl()),

            Stat::make(__('Pending Tasks'), $pendingTasks)
                ->description(__('Awaiting execution'))
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('warning')
                ->url(\Modules\Task\Filament\Resources\TaskResource::getUrl()),

            Stat::make(__('Completed Today'), $completedTasksToday)
                ->description(__('Tasks finished today'))
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('info')
                ->url(\Modules\Task\Filament\Resources\TaskResource::getUrl()),
        ];
    }
}
