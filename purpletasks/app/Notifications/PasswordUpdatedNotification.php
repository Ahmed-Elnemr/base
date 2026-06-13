<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

class PasswordUpdatedNotification extends Notification
{
    use Queueable, SerializesModels;

    public function __construct()
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => [
                'en' => 'Security Alert: Password Changed',
                'ar' => 'تنبيه أمني: تم تغيير كلمة المرور'
            ],
            'body' => [
                'en' => 'Your password has been updated successfully. If you did not perform this action, please contact support immediately.',
                'ar' => 'تم تحديث كلمة المرور الخاصة بك بنجاح. إذا لم تقم بهذا الإجراء، يرجى التواصل مع الدعم الفني فوراً.'
            ],
            'type' => 'security_alert',
            'model_id' => $notifiable->id,
        ];
    }
}
