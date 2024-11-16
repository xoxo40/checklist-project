<?php

namespace App\Filament\Employee\Resources\UserTaskResource\Pages;

use App\Filament\Employee\Resources\UserTaskResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\UserTask;
use App\Models\Task;

class CreateUserTask extends CreateRecord
{
    protected static string $resource = UserTaskResource::class;



    protected function handleRecordCreation(array $data): UserTask
{
    //dd($data);
    

    $data['task_details'] = json_encode($data['task_details']); // Convertir les détails de la tâche en JSON

    // Créer un enregistrement dans la base de données
    return UserTask::create([
        'task_id' => $data['task_id'],
        'name_employee' => $data['name_employee'], // Assurez-vous d'inclure l'ID de l'employé
        'task_details' => $data['task_details'],
        'is_completed' => $data['is_completed'] ?? 'non_commence',
        'date' => $data['date'],
        'commentaire' => $data['commentaire'] ?? null,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}

}
