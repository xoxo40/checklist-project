<?php

namespace App\Console\Commands;

use App\Models\Task;  // Assure-toi d'importer le modèle Task
use Carbon\Carbon;    // Assure-toi d'importer Carbon
use Illuminate\Console\Command;

class CreateRecurringTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:create-recurring';  // Signature de la commande

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Créer les tâches récurrentes pour aujourd\'hui'; // Description de la commande

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Récupère le jour actuel (ex: "lundi", "mardi", etc.)
        $today = Carbon::now()->locale('fr')->isoFormat('dddd');  

        // Récupère toutes les tâches récurrentes correspondant au jour actuel
        $recurringTasks = Task::where('recurrence', $today)->get();

        // Pour chaque tâche récurrente, on la clone pour aujourd'hui
        foreach ($recurringTasks as $task) {
            // Crée une nouvelle tâche en utilisant les mêmes informations que la tâche récurrente
            Task::create([
                'checklist_id' => $task->checklist_id,  // Utilise l'ID de la checklist
                'name_employee' => $task->name_employee,  // Nom de l'employé assigné
                'task_details' => $task->task_details,  // Détails de la tâche
                'date' => $task->date,  // La date de la tâche pour aujourd'hui
                'deadline' => $task->deadline,  // Date limite : 1 semaine après
                'recurrence' => null,  // La tâche clonée ne sera plus récurrente
            ]);
        }

        // Affiche un message dans la console pour confirmer la création des tâches
        $this->info('Tâches récurrentes créées avec succès.');
    }
}
