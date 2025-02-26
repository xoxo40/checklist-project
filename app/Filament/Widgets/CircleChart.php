<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\UserTask;

class CircleChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected static ?string $heading = "Données d'aujourd'hui des statut";

    protected function getData(): array
    {
        // Comptage des tâches selon leur statut
        $completedCount = UserTask::where('is_completed', 'complet')->count();
        $inProgressCount = UserTask::where('is_completed', 'en_cours')->count();
        $notStartedCount = UserTask::where('is_completed', 'non_commence')->count();

        return [
            'labels' => ['Terminé', 'En cours', 'Commencé'],
            'datasets' => [
                [
                    'label' => 'Statistiques des tâches',
                    'data' => [$completedCount, $inProgressCount, $notStartedCount],
                    'backgroundColor' => [
                        'rgba(0, 128, 0, 0.2)', // Vert pour "Terminé"
                        'rgba(255, 206, 86, 0.2)', // Jaune pour "En cours"
                        'rgba(255, 99, 132, 0.2)', // Rouge pour "Commencé"
                    ],
                    'borderColor' => [
                        'rgba(0, 128, 0, 1)', // Bordure verte
                        'rgba(255, 206, 86, 1)', // Bordure jaune
                        'rgba(255, 99, 132, 1)', // Bordure rouge
                    ],
                    'borderWidth' => 1,
                ],
            ],
            'options' => [
                'responsive' => true, // Permet d'ajuster le graphique à la taille de l'écran
                'animation' => [
                    'duration' => 1500, // Durée de l'animation
                    'easing' => 'easeOutBounce', // Type de transition de l'animation
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'pie'; // Type de graphique : CircleChart (Graphique en secteur)
    }
}
