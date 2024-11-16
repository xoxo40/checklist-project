<?php

namespace App\Providers;

use Filament\Filament; // Vérifiez que cette ligne est présente et correcte
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Vérifiez si la classe Filament existe avant de l'utiliser
        if (class_exists(Filament::class)) {
            Filament::serving(function () {
                // Actions à effectuer lors du chargement de Filament
            });
        } else {
            // Gestion de l'erreur ou du cas où la classe n'existe pas
            \Log::error('La classe Filament n\'a pas été trouvée.');
        }
    }
}
