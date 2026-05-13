<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

/**
 * إشعار تسجيل مستخدم جديد
 * يُرسل للإدارة عند تسجيل مستخدم جديد في النظام
 */
class NewUserRegisteredNotification extends Notification
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
        $clientType = $this->user->client_type === 'company' 
            ? ['en' => 'Company', 'ar' => 'شركة']
            : ['en' => 'Individual', 'ar' => 'فرد'];

        return [
            'title' => [
                'en' => 'New User Registered',
                'ar' => 'تسجيل مستخدم جديد'
            ],
            'body' => [
                'en' => 'New ' . $clientType['en'] . ' registered: ' . $this->user->name,
                'ar' => 'تم تسجيل ' . $clientType['ar'] . ' جديد: ' . $this->user->name
            ],
            'type' => 'new_user',
            'model_id' => $this->user->id,
        ];
    }
}
