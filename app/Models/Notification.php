<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    // Colonnes pouvant être remplies en masse
    protected $fillable = [
        'user_task_id',
        'message',
        'is_read',
        'is_processed',
        'read_at',
    ];

    // Définition des types pour les colonnes
    protected $casts = [
        'is_read' => 'boolean',
        'is_processed' => 'boolean',
        'read_at' => 'datetime',
    ];

    // Nom explicite de la table
    protected $table = 'notifications';

    // Relation avec la tâche liée
    public function userTask()
    {
        return $this->belongsTo(UserTask::class, 'user_task_id');
    }
}
