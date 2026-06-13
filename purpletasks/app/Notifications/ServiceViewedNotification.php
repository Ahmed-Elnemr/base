<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

/**
 * إشعار مشاهدة خدمة
 * يُرسل للإدارة عند مشاهدة مستخدم لتفاصيل خدمة معينة
 */
class ServiceViewedNotification extends Notification
{
    use Queueable, SerializesModels;

    protected User $user;
    protected int $serviceId;
    protected string $serviceTitle;

    public function __construct(User $user, int $serviceId, string $serviceTitle)
    {
        $this->user = $user;
        $this->serviceId = $serviceId;
        $this->serviceTitle = $serviceTitle;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => [
                'en' => 'Service Viewed',
                'ar' => 'مشاهدة خدمة'
            ],
            'body' => [
                'en' => $this->user->name . ' viewed service: ' . $this->serviceTitle,
                'ar' => 'قام ' . $this->user->name . ' بمشاهدة خدمة: ' . $this->serviceTitle
            ],
            'type' => 'service_view',
            'model_id' => $this->serviceId,
            'user_id' => $this->user->id,
        ];
    }
}
