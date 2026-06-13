<?php

namespace Modules\Task\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Trait\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Task\app\Models\Task;

class TaskController extends Controller
{
    use ResponseTrait;

    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $status = $request->query('status');

        $query = Task::where('user_id', $user->id);

        if ($status) {
            $query->where('status', $status);
        }

        $tasks = $query->orderBy('due_date', 'asc')->get();

        return self::successResponse(__('Tasks retrieved successfully.'), $tasks);
    }

    public function start(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        $task = Task::where('id', $id)->where('user_id', $user->id)->first();

        if (! $task) {
            return self::failResponse(404, __('Task not found.'));
        }

        $task->update([
            'status' => 'in_progress',
        ]);

        return self::successResponse(__('Task started successfully.'), $task);
    }

    public function complete(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        $task = Task::where('id', $id)->where('user_id', $user->id)->first();

        if (! $task) {
            return self::failResponse(404, __('Task not found.'));
        }

        $task->update([
            'status' => 'completed',
        ]);

        return self::successResponse(__('Task completed successfully.'), $task);
    }
}
