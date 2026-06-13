<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class UserStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('Total Users'), User::count())
                ->description(__('All registered users'))
                ->descriptionIcon('heroicon-m-users')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('primary'),

            Stat::make(__('Active Users'), User::where('status', 'active')->count())
                ->description(__('Users currently active'))
                ->descriptionIcon('heroicon-m-check-circle')
                ->chart([2, 5, 4, 6, 8, 3, 9])
                ->color('success'),

            Stat::make(__('New This Month'), User::whereMonth('created_at', Carbon::now()->month)->count())
                ->description(__('Users registered this month'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([1, 0, 2, 3, 5, 2, 7])
                ->color('info'),
        ];
    }
}
