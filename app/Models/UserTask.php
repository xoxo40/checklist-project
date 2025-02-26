<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTask extends Model
{
    use HasFactory;

    protected $table = 'user_tasks';

    protected $fillable = [

        'task_id',
        'name_employee',
        'task_details',
        'is_completed',
        'commentaire',
        'date',
    ];

    // Relations

    // Relation avec le modèle Task
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    // Relation avec le modèle Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    // Relation avec le modèle Checklist si applicable
    public function checklist()
    {
        return $this->belongsTo(Checklist::class, 'checklist_id');
    }

    // Accessor pour obtenir les détails de la tâche
    public function getTaskDetailsAttribute()
    {
        return $this->task ? $this->task->task_details : null; // Récupérer les détails de la tâche
    }

    public function getTaskChecklistIdAttribute()
    {
        return $this->task ? $this->task->checklist_id : null;
    }

    

    

    


    
}

