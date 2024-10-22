<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;

    // Les attributs pouvant être assignés en masse
    protected $fillable = [
        'title',
        'description',
        'created_by',
    ];

    // Relation avec le modèle User
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Autres relations et méthodes peuvent être ajoutées ici
}

