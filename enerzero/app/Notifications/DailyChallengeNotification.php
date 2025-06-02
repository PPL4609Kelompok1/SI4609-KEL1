<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DailyChallengeNotification extends Notification
{
    use Queueable;

    protected $message;

    public function __construct($message = 'Jangan lupa ikuti misi harian hari ini untuk mendapatkan poin tambahan!')
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->message,
            'url' => route('challenge.index') // arahkan ke halaman tantangan
        ];
    }

}
