<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\UserTask;

class UserTaskChecklist extends Component
{
    public $userTasks;

    // Initialisation des tâches assignées à l'utilisateur
    public function mount($userId)
    {
        // Récupère les tâches assignées à un utilisateur spécifique
        $this->userTasks = UserTask::where('employee_id', $userId)->get();
    }

    // Méthode pour mettre à jour le statut de la tâche
    public function toggleTaskCompletion($taskId)
    {
        $task = UserTask::find($taskId);
        $task->is_completed = !$task->is_completed; // Change l'état de complétion
        $task->save(); // Sauvegarde la modification

        // Met à jour la liste des tâches après modification
        $this->userTasks = UserTask::where('employee_id', $task->employee_id)->get();
    }

    public function render()
    {
        return view('livewire.user-task-checklist');
    }
}

