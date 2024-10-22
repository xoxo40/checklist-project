<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // Les attributs pouvant être assignés en masse
    protected $fillable = [
        'checklist_id', // Associe la tâche à une checklist
        'description',  // Description de la tâche
    ];

    // Relation avec le modèle Checklist
    public function checklist()
    {
        return $this->belongsTo(Checklist::class, 'checklist_id');
    }
}
