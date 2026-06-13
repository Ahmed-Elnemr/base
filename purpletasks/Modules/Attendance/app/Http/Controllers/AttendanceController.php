<?php

namespace Modules\Attendance\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Trait\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Attendance\app\Models\Attendance;
use Modules\Task\app\Models\Task;

class AttendanceController extends Controller
{
    use ResponseTrait;

    public function clockIn(Request $request): JsonResponse
    {
        $user = $request->user();
        $today = Carbon::today()->toDateString();

        $existing = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->where('status', 'active')
            ->first();

        if ($existing) {
            return self::failResponse(400, __('Already clocked in.'));
        }

        $attendance = Attendance::create([
            'user_id' => $user->id,
            'date' => $today,
            'start_time' => Carbon::now(),
            'status' => 'active',
        ]);

        return self::successResponse(__('Clocked in successfully.'), $attendance);
    }

    public function clockOut(Request $request): JsonResponse
    {
        $user = $request->user();
        $today = Carbon::today()->toDateString();

        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->where('status', 'active')
            ->first();

        if (! $attendance) {
            return self::failResponse(400, __('No active session found for today.'));
        }

        $now = Carbon::now();
        $startTime = Carbon::parse($attendance->start_time);
        $totalHours = $startTime->diffInMinutes($now) / 60.0;

        $attendance->update([
            'end_time' => $now,
            'total_hours' => round($totalHours, 2),
            'status' => 'completed',
        ]);

        return self::successResponse(__('Clocked out successfully.'), $attendance);
    }

    public function status(Request $request): JsonResponse
    {
        $user = $request->user();
        $today = Carbon::today()->toDateString();

        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->where('status', 'active')
            ->first();

        return self::successResponse(__('Status retrieved.'), [
            'is_active' => ! is_null($attendance),
            'session' => $attendance,
        ]);
    }

    public function summary(Request $request): JsonResponse
    {
        $user = $request->user();
        $today = Carbon::today()->toDateString();
        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();

        // Active session today
        $todaySession = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        // Tasks count
        $todayTasksCount = Task::where('user_id', $user->id)
            ->whereDate('due_date', $today)
            ->count();

        $completedTasksCount = Task::where('user_id', $user->id)
            ->whereDate('due_date', $today)
            ->where('status', 'completed')
            ->count();

        // Total hours worked this month
        $totalHoursMonth = Attendance::where('user_id', $user->id)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->where('status', 'completed')
            ->sum('total_hours');

        // Best daily achievement (max hours worked in a day this month)
        $bestAchievement = Attendance::where('user_id', $user->id)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->where('status', 'completed')
            ->max('total_hours') ?: 0.0;

        return self::successResponse(__('Summary retrieved.'), [
            'date' => Carbon::now()->toDateString(),
            'is_active' => $todaySession ? ($todaySession->status === 'active') : false,
            'today_tasks' => $todayTasksCount,
            'completed_tasks' => $completedTasksCount,
            'total_hours_today' => $todaySession ? $todaySession->total_hours : 0.0,
            'session_data' => $todaySession ? [
                'start_time' => $todaySession->start_time ? Carbon::parse($todaySession->start_time)->format('H:i:s') : null,
                'end_time' => $todaySession->end_time ? Carbon::parse($todaySession->end_time)->format('H:i:s') : null,
                'date' => $todaySession->date->toDateString(),
            ] : null,
            'employee_tally' => [
                'best_achievement' => round($bestAchievement, 2),
                'total_hours_month' => round($totalHoursMonth, 2),
            ],
        ]);
    }

    public function history(Request $request): JsonResponse
    {
        $user = $request->user();
        $history = Attendance::where('user_id', $user->id)
            ->whereIn('status', ['active', 'completed'])
            ->orderBy('date', 'desc')
            ->get()
            ->map(function ($item) {
                $workPeriod = 'N/A';
                if ($item->start_time) {
                    $start = Carbon::parse($item->start_time)->format('H:i');
                    $end = $item->end_time ? Carbon::parse($item->end_time)->format('H:i') : '--:--';
                    $workPeriod = $start.' - '.$end;
                }

                return [
                    'id' => $item->id,
                    'date' => $item->date->toDateString(),
                    'day_name' => $item->date->translatedFormat('l'),
                    'work_period' => $workPeriod,
                    'total_time' => $item->total_hours,
                    'achievement_report' => $item->achievement_report,
                    'deduction_value' => $item->deduction_value,
                    'deduction_reason' => $item->deduction_reason,
                    'status' => $item->status,
                ];
            });

        return self::successResponse(__('History retrieved.'), $history);
    }

    public function days(Request $request): JsonResponse
    {
        $user = $request->user();
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $daysInMonth = Carbon::now()->daysInMonth;

        $attendances = Attendance::where('user_id', $user->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get()
            ->keyBy(fn ($item) => $item->date->toDateString());

        $days = [];
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $date = Carbon::create($year, $month, $d);
            $dateStr = $date->toDateString();
            $att = $attendances->get($dateStr);

            $status = 'open'; // default open for today/future
            if ($date->isPast() && ! $date->isToday()) {
                $status = 'closed';
            }

            // Friday is usually a holiday
            if ($date->isFriday()) {
                $status = 'holiday';
            }

            $days[] = [
                'date' => $dateStr,
                'day_name' => $date->translatedFormat('l'),
                'status' => $status,
                'achievement_report' => $att ? $att->achievement_report : null,
                'has_attendance' => ! is_null($att),
            ];
        }

        return self::successResponse(__('Days of the month retrieved.'), $days);
    }

    public function saveDailyReport(Request $request): JsonResponse
    {
        $request->validate([
            'date' => 'required|date',
            'achievement_report' => 'required|string',
        ]);

        $user = $request->user();
        $date = Carbon::parse($request->date)->toDateString();

        $attendance = Attendance::firstOrCreate(
            ['user_id' => $user->id, 'date' => $date],
            ['status' => 'inactive']
        );

        $attendance->update([
            'achievement_report' => $request->achievement_report,
        ]);

        return self::successResponse(__('Report saved successfully.'), $attendance);
    }
}
