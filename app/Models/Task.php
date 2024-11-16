<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // Définir les attributs pouvant être assignés en masse
    protected $fillable = [
        'checklist_id',         // Clé étrangère vers la table checklists
        'name_employee',
        'task_details',        // Détails de la tâche
        'date',                 // Date associée à la tâche
    ];

    /**
     * Relation avec le modèle Checklist
     * Une tâche appartient à une checklist via l'ID.
     */
    public function checklist()
    {
        return $this->belongsTo(Checklist::class); // Relation basée sur la clé étrangère checklist_id
    }

    /**
     * Récupère la description de la checklist associée.
     */
    public function getChecklistDescriptionAttribute()
    {
        return $this->checklist ? $this->checklist->description : null;
    }

    public function getEmployeeUsernameAttribute()
    {
        return $this->checklist && $this->checklist->employee 
            ? $this->checklist->employee->name_employee : null;
    }
    // Checklist.php
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

}
