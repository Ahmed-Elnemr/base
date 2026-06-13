<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Attendance\app\Models\Attendance;
use Illuminate\Support\Carbon;

class AttendanceChartWidget extends ChartWidget
{
    protected static ?int $sort = 3;

    public function getHeading(): string
    {
        return __('Attendance Trends');
    }

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $labels[] = Carbon::now()->subDays($i)->format('M d');
            $count = Attendance::whereDate('date', $date)->count();
            $data[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => __('Attendances'),
                    'data' => $data,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
