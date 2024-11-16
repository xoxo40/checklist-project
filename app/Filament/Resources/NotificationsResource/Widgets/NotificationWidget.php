<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class NotificationWidget extends Widget
{
    protected static string $view = 'filament.widgets.notification-widget'; // Chemin de la vue

    public function getNotifications()
    {
        return Auth::user()->notifications; // Récupère les notifications de l'utilisateur authentifié
    }
} 
