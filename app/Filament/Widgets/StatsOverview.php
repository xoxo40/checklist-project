<?php

namespace App\Filament\Widgets;
use App\Models\Task;
use App\Models\UserTask;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected static ?string $pollingInterval = '15s';
    


    protected static bool $islazy = true;

    protected function getStats(): array
    {
        return [
            stat::make('Total des tâches', Task::query()->count())
            ->description(description: "Nombre total de tâches d'aujourd'hu")
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            
            ->color(color: 'info')
            ->chart([7, 3, 4, 5, 6, 3, 5, 3]),

            stat::make('Tâche en cours', UserTask::where('is_completed', 'en_cours')->count())
            ->description('Total des tâches en cours')
            ->descriptionIcon('heroicon-m-arrow-trending-down')
            ->color('warning')
            ->chart([4, 5, 3, 5, 6, 7, 3]),

        stat::make('Tâche terminée', UserTask::where('is_completed', 'complet')->count())
            ->description(' Total des tâches terminées')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->color('success')
            ->chart([6, 4, 3, 7, 5, 3, 4]),
        ];
    }
}
