<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Models\Notification as NotificationModel;

class CustomNotification extends Notification
{
    protected $notification;

    // Injecte une instance du modèle Notification
    public function __construct(NotificationModel $notification)
    {
        $this->notification = $notification;
    }

    // Définit les canaux utilisés pour envoyer la notification
    public function via($notifiable)
    {
        return ['database']; // Notification stockée en base de données
    }

    // Définit le contenu stocké dans la base de données
    public function toDatabase($notifiable)
    {
        return [
            'id' => $this->notification->id,
            'message' => $this->notification->message,
            'user_task_id' => $this->notification->user_task_id,
            'created_at' => $this->notification->created_at,
            'is_read' => $this->notification->is_read,
        ];
    }
}
