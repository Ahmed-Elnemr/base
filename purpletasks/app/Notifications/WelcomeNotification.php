<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

class WelcomeNotification extends Notification
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
                'en' => 'Welcome to Elmo5afed!',
                'ar' => 'أهلاً بك في المخفض!'
            ],
            'body' => [
                'en' => 'Welcome ' . $notifiable->name . ', we are glad to have you with us. Explore our services now.',
                'ar' => 'أهلاً بك يا ' . $notifiable->name . '، نسعد بوجودك معنا. ابدأ الآن واستكشف خدماتنا.'
            ],
            'type' => 'welcome',
            'model_id' => $notifiable->id,
        ];
    }
}
