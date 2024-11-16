<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NomDeLaNotification extends Notification
{
    use Queueable;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return ['database']; // Vous pouvez aussi utiliser 'mail', 'nexmo', etc.
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->data['message'],
        ];
    }
}
