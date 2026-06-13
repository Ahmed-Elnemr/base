<?php

namespace Modules\Attendance\Filament\Resources\AttendanceResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Attendance\app\Models\Attendance;
use Illuminate\Support\Carbon;

class AttendanceStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('Today\'s Attendances'), Attendance::whereDate('date', Carbon::today())->count())
                ->description(__('Employees clocked in today'))
                ->descriptionIcon('heroicon-m-calendar-days')
                ->chart([2, 3, 5, 4, 8, 5, 7])
                ->color('success'),

            Stat::make(__('Active Now'), Attendance::where('status', 'active')->whereDate('date', Carbon::today())->count())
                ->description(__('Currently working'))
                ->descriptionIcon('heroicon-m-clock')
                ->chart([1, 2, 3, 4, 3, 5, 6])
                ->color('primary'),

            Stat::make(__('Total Hours (Month)'), round(Attendance::whereMonth('date', Carbon::now()->month)->sum('total_hours'), 1))
                ->description(__('Hours logged this month'))
                ->descriptionIcon('heroicon-m-chart-bar')
                ->chart([10, 15, 20, 18, 25, 22, 30])
                ->color('info'),
        ];
    }
}
