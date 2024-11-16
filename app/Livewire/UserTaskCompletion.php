<?php

namespace App\Http\Controllers;

use App\Models\UserTask;
use App\Models\Task; // Assurez-vous que ce modèle est importé
use Illuminate\Http\Request;

class UserTaskCompletion extends Controller
{
    // Afficher les tâches à vérifier pour un utilisateur spécifique
    public function showTasks($id)
    {
        $userTask = UserTask::with('task')->findOrFail($id); // Récupérer la tâche utilisateur
        // Récupérer toutes les tâches associées à cette UserTask
        $tasks = Task::where('user_task_id', $id)->get(); // Adaptez selon votre relation

        return view('user-task-checklist', compact('userTask', 'tasks')); // Passez les tâches à la vue
    }

    // Mettre à jour l'état des tâches et les commentaires
    public function update(Request $request, $id)
    {
        $userTask = UserTask::findOrFail($id);
        
        // Mise à jour de l'état des tâches
        foreach ($request->input('tasks', []) as $taskId => $isCompleted) {
            $task = Task::find($taskId);
            if ($task) {
                $task->is_completed = (bool) $isCompleted;
                $task->save();
            }
        }

        // Mise à jour du commentaire
        $userTask->commentaire = $request->input('commentaire');
        $userTask->is_completed = $userTask->tasks->every->is_completed; // Vérifie si toutes les tâches sont complétées
        $userTask->save();

        return redirect()->back()->with('success', 'Tâches mises à jour avec succès');
    }
}
