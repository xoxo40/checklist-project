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

    // Relation avec le modèle Employe
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'created_by'); // Assurez-vous que 'created_by' fait référence à la clé primaire de la table employees
    }

    // Méthode pour récupérer le nom d'utilisateur de l'employé
    public function getEmployeeUsername()
    {
        return $this->employee ? $this->employee->username : 'Inconnu'; // Utilisation de 'username' pour obtenir le nom de l'employé
    }

    // Autres relations et méthodes peuvent être ajoutées ici
}
