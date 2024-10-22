<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTask extends Model
{
    use HasFactory;

    // Les attributs pouvant être assignés en masse
    protected $fillable = [
        'task_id',
        'user_id',
        'is_completed',
    ];

    // Relation avec le modèle Task
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    // Relation avec le modèle User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}


