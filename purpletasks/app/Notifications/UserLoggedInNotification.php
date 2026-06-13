<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

/**
 * إشعار تسجيل دخول مستخدم جديد
 * يُرسل للإدارة عند تسجيل دخول أي مستخدم
 */
class UserLoggedInNotification extends Notification
{
    use Queueable, SerializesModels;

    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => [
                'en' => 'User Logged In',
                'ar' => 'تسجيل دخول مستخدم'
            ],
            'body' => [
                'en' => $this->user->name . ' has logged in to the system',
                'ar' => 'قام ' . $this->user->name . ' بتسجيل الدخول إلى النظام'
            ],
            'type' => 'user_login',
            'model_id' => $this->user->id,
        ];
    }
}
