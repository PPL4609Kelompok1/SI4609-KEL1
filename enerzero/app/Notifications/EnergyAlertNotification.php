<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class EnergyAlertNotification extends Notification
{
    use Queueable;

    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
        if (!isset($this->data['url'])) {
            $this->data['url'] = route('energy.index'); // Pastikan route 'energy.index' sesuai route energy usage report
        }
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->data['message'],
            'url' => $this->data['url'] ?? null,
        ];
    }
}
