<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * إشعار طلب جديد
 * يُرسل عند إنشاء طلب جديد
 */
class NewOrderNotification extends Notification
{
    use Queueable, SerializesModels;

    protected int $orderId;
    protected string $orderNumber;

    public function __construct(int $orderId, string $orderNumber)
    {
        $this->orderId = $orderId;
        $this->orderNumber = $orderNumber;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => [
                'en' => 'New Order Received',
                'ar' => 'تم استلام طلب جديد'
            ],
            'body' => [
                'en' => 'You have received a new order #' . $this->orderNumber,
                'ar' => 'لديك طلب جديد رقم ' . $this->orderNumber
            ],
            'type' => 'new_order',
            'model_id' => $this->orderId,
        ];
    }
}
