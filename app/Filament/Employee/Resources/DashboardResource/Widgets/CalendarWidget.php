<?php 
namespace App\Filament\Employee\Resources\DashboardResource\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Carbon\Carbon;
use Filament\Support\Facades\FilamentView;
use App\Models\Task;

class CalendarWidget extends FullCalendarWidget 
{
    public function getViewData(): array 
    {
        // Récupérer toutes les tâches pour l'affichage du calendrier
        $tasks = Task::all();

        // Mapper les tâches en un format compatible avec FullCalendar
        $events = $tasks->map(function ($task) {
            // Récupérer le nom de l'employé associé à la checklist
            $employeeName = $task->checklist->employee->username ?? 'Nom de l\'employé non défini';

            // Ajuster l'heure de début à 08h00
            $startTime = Carbon::parse($task->date)->setTime(8, 0); // Définit l'heure à 08h00

            return [
                'title' => $task->checklist->description . ' - ' . $employeeName,  // Titre avec la tâche et le nom de l'employé
                'start' => $startTime->toIso8601String(),  // Utilisation de $startTime avec l'heure ajustée à 08h00
                'end' => Carbon::parse($task->deadline)->addHours(2)->toIso8601String(),  // La date de fin (ajustez selon le besoin)
                'allDay' => false
            ];
        })->toArray();

        // Ajouter des logs pour déboguer
        info('Calendar Events:', $events);
        
        return $events;
    }

    public function config(): array 
    {
        return [
            'initialView' => 'dayGridMonth',
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,timeGridWeek,timeGridDay'
            ],
            //'displayEventTime' => false, // Désactive l'affichage de l'heure
            'events' => $this->getViewData(),  // Utilisation des événements récupérés depuis la base de données
            'eventSources' => [
                [
                    'events' => $this->getViewData()  // Event source
                ]
            ]
        ];
    }
}
