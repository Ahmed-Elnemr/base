<?php

namespace App\Filament\Widgets;
use App\Models\Admin;
use App\Models\User;
use Carbon\Carbon;
use Modules\Blog\app\Models\BlogPost;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;

class HomeWidgets extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            $this->getUserStats(),
            $this->getAdminStats(),
            $this->getBlogStats(),
        ];
    }
    protected static ?int $sort = 1;


    protected function getUserStats(): Stat
    {
        $currentCount = User::where('status',1)->count();
        $lastMonthCount = User::where('status',1)
            ->where('created_at', '<', Carbon::now()->subMonth())
            ->count();

        $increase = $currentCount - $lastMonthCount;
        $increasePercentage = $lastMonthCount > 0 ? round(($increase / $lastMonthCount) * 100) : 100;

        return Stat::make(__('Clients Active'), $currentCount)
            ->description($this->getTrendDescription($increase, $increasePercentage))
            ->descriptionIcon($this->getTrendIcon($increase))
            ->chart($this->getWeeklyData(User::class))
            ->color($this->getTrendColor($increase));
    }
    protected function getAdminStats(): Stat
    {
        $currentCount = Admin::where('status',1)->count();
        $lastMonthCount = Admin::where('status',1)
            ->where('created_at', '<', Carbon::now()->subMonth())
            ->count();

        $increase = $currentCount - $lastMonthCount;
        $increasePercentage = $lastMonthCount > 0 ? round(($increase / $lastMonthCount) * 100) : 100;

        return Stat::make(__('Admins Active'), $currentCount)
            ->description($this->getTrendDescription($increase, $increasePercentage))
            ->descriptionIcon($this->getTrendIcon($increase))
            ->chart($this->getWeeklyData(Admin::class))
            ->color($this->getTrendColor($increase));
    }

    protected function getBlogStats(): Stat
    {
        $currentCount = BlogPost::active()->count();
        $lastMonthCount = BlogPost::active()
            ->where('created_at', '<', Carbon::now()->subMonth())
            ->count();

        $increase = $currentCount - $lastMonthCount;
        $increasePercentage = $lastMonthCount > 0 ? round(($increase / $lastMonthCount) * 100) : 100;

        return Stat::make(__('Blog Posts Active'), $currentCount)
            ->description($this->getTrendDescription($increase, $increasePercentage))
            ->descriptionIcon($this->getTrendIcon($increase))
            ->chart($this->getWeeklyData(BlogPost::class, ['is_active' => true]))
            ->color($this->getTrendColor($increase));
    }


    protected function getTrendDescription(int $change, ?int $percentage = null): string
    {
        if ($percentage === null) {
            $percentage = $change != 0 ? round(abs($change) / ($change + $change) * 100) : 0;
        }

        return $change >= 0
            ? __("increase") . " {$percentage}% (▲ {$change})"
            : __("decrease") . " {$percentage}% (▼ " . abs($change) . ")";
    }

    protected function getTrendIcon(int $change): string
    {
        return $change >= 0
            ? 'heroicon-m-arrow-trending-up'
            : 'heroicon-m-arrow-trending-down';
    }

    protected function getTrendColor(int $change): string
    {
        return $change >= 0 ? 'success' : 'danger';
    }

    protected function getWeeklyData(string $model, array $conditions = []): array
    {
        return Cache::remember("weekly_stats_{$model}_" . implode('_', $conditions), 3600, function() use ($model, $conditions) {
            return collect(range(6, 0))
            ->map(function ($days) use ($model, $conditions) {
                $query = $model::query();

                foreach ($conditions as $column => $value) {
                    $query->where($column, $value);
                }

                return $query->whereDate('created_at', today()->subDays($days))
                    ->count();
            })
                ->toArray();
        });
    }

}
