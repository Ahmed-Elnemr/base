<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

class AccountStatusNotification extends Notification
{
    use Queueable, SerializesModels;

    protected string $status;

    public function __construct(string $status)
    {
        $this->status = $status;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $isActive = $this->status === 'active' || $this->status === '1';

        return [
            'title' => [
                'en' => $isActive ? 'Account Activated' : 'Account Deactivated',
                'ar' => $isActive ? 'تم تفعيل الحساب' : 'تم تعطيل الحساب'
            ],
            'body' => [
                'en' => $isActive 
                    ? 'Your account has been activated. You can now use all features.' 
                    : 'Your account has been deactivated. Please contact administration for more info.',
                'ar' => $isActive 
                    ? 'تم تفعيل حسابك بنجاح. يمكنك الآن استخدام كافة مميزات التطبيق.' 
                    : 'تم تعطيل حسابك. يرجى التواصل مع الإدارة لمزيد من التفاصيل.'
            ],
            'type' => 'account_status',
            'model_id' => $notifiable->id,
            'status' => $this->status
        ];
    }
}
