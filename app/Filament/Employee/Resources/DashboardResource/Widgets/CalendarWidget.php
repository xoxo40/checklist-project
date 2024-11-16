<?php

namespace App\Filament\Employee\Resources\DashboardResource\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    protected function getViewData(): array
    {
        // Retourne un tableau vide pour afficher un calendrier sans événements
        return [];
    }
}
