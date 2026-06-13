<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Get all notifications for the authenticated user.
     */
    public function index(): JsonResponse
    {
        $user = auth('sanctum')->user();
        $notifications = $user->notifications()->paginate(10);
        
        // Mark all unread notifications as read
        $user->unreadNotifications->markAsRead();
        
        return response()->json([
            'success' => true,
            'message' => __('Notifications loaded successfully.'),
            'data' => [
                'notifications' => NotificationResource::collection($notifications)->response()->getData(true)
            ]
        ]);
    }

    /**
     * Get the count of unread notifications.
     */
    public function unreadCount(): JsonResponse
    {
        $unreadCount = Auth::user()->unreadNotifications()->count();
        
        return response()->json([
            'success' => true,
            'message' => __('Unread notifications count retrieved.'),
            'data' => [
                'unread_count' => $unreadCount
            ]
        ]);
    }

    /**
     * Get all unread notifications for the authenticated user.
     */
    public function unread(): JsonResponse
    {
        $user = auth('sanctum')->user();
        $notifications = $user->unreadNotifications()->paginate(10);
        
        return response()->json([
            'success' => true,
            'message' => __('Unread notifications loaded successfully.'),
            'data' => [
                'notifications' => NotificationResource::collection($notifications)->response()->getData(true)
            ]
        ]);
    }

    /**
     * Delete a specific notification.
     */
    public function deleteNotification(string $uuid): JsonResponse
    {
        $user = auth('sanctum')->user();
        $notification = $user->notifications()->where('id', $uuid)->first();

        if (!$notification) {
            return response()->json([
                'success' => false,
                'message' => __('Notification not found.'),
            ], 404);
        }

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => __('Notification deleted successfully.'),
        ]);
    }

    /**
     * Delete all notifications for the authenticated user.
     */
    public function deleteAllNotifications(): JsonResponse
    {
        $user = auth('sanctum')->user();
        $user->notifications()->delete();

        return response()->json([
            'success' => true,
            'message' => __('All notifications deleted successfully.'),
        ]);
    }
}
