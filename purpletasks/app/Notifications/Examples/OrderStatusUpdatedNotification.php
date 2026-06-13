<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

/**
 * إشعار تحديث حالة الطلب
 * يُرسل عند تغيير حالة الطلب
 */
class OrderStatusUpdatedNotification extends Notification
{
    use Queueable, SerializesModels;

    protected int $orderId;
    protected string $orderNumber;
    protected string $status;
    protected string $statusAr;

    public function __construct(int $orderId, string $orderNumber, string $status, string $statusAr)
    {
        $this->orderId = $orderId;
        $this->orderNumber = $orderNumber;
        $this->status = $status;
        $this->statusAr = $statusAr;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => [
                'en' => 'Order Status Updated',
                'ar' => 'تم تحديث حالة الطلب'
            ],
            'body' => [
                'en' => 'Your order #' . $this->orderNumber . ' is now ' . $this->status,
                'ar' => 'طلبك رقم ' . $this->orderNumber . ' الآن ' . $this->statusAr
            ],
            'type' => 'order_status_update',
            'model_id' => $this->orderId,
        ];
    }
}
