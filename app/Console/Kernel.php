<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Définir les commandes artisan.
     *
     * @var array
     */
    protected $commands = [
        // Ajouter la commande ici si nécessaire
        \App\Console\Commands\CreateRecurringTasks::class,  // Ajoute ta commande ici
    ];

    /**
     * Définir la planification des commandes artisan.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Planifie la commande pour qu'elle s'exécute tous les jours à minuit
        $schedule->command('tasks:generate-recurring')->weekly();
    }

    /**
     * Définir les commandes de l'application.
     *
     * @return void
     */
    protected function commands()
    {
        // Enregistre les commandes dans le répertoire app/Console/Commands
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
