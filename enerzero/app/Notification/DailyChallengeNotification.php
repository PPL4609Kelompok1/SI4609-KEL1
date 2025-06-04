<?php

// app/Notifications/DailyChallengeNotification.php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class DailyChallengeNotification extends Notification
{
    public $message;

    public function __construct($message = 'Jangan lupa ikuti misi harian hari ini untuk mendapatkan poin tambahan!')
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // Email dan in-app notification
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Jangan Lewatkan Misi Harianmu!')
            ->line($this->message)
            ->action('Ikuti Misi', url('/missions/daily'))
            ->line('Jangan sampai terlewat ya!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->message,
            'url' => url('/missions/daily')
        ];
    }
}