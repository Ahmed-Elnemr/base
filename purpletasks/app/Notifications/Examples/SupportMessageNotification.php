<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

/**
 * إشعار رسالة جديدة من الدعم
 * يُرسل عند استلام رسالة من فريق الدعم
 */
class SupportMessageNotification extends Notification
{
    use Queueable, SerializesModels;

    protected int $ticketId;
    protected string $message;

    public function __construct(int $ticketId, string $message = '')
    {
        $this->ticketId = $ticketId;
        $this->message = $message;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => [
                'en' => 'New Support Message',
                'ar' => 'رسالة جديدة من الدعم'
            ],
            'body' => [
                'en' => 'You have a new message from support team',
                'ar' => 'لديك رسالة جديدة من فريق الدعم'
            ],
            'type' => 'support_message',
            'model_id' => $this->ticketId,
        ];
    }
}
