<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Notification;

class NotificationWidget extends Widget
{
    protected static string $view = 'filament.widgets.notification-widget';
    
    public function getNotifications()
    {
        return Notification::with(['usertask', 'employee'])
            ->where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}

