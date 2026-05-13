<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

/**
 * إشعار تحديث الملف الشخصي
 * يُرسل للإدارة عند تحديث المستخدم لملفه الشخصي
 */
class ProfileUpdatedNotification extends Notification
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
                'en' => 'Profile Updated',
                'ar' => 'تحديث الملف الشخصي'
            ],
            'body' => [
                'en' => $this->user->name . ' has updated their profile',
                'ar' => 'قام ' . $this->user->name . ' بتحديث ملفه الشخصي'
            ],
            'type' => 'profile_update',
            'model_id' => $this->user->id,
        ];
    }
}
