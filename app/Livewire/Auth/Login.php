<?php
namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class Login extends Component
{
    public $email;
    public $password;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:1',
    ];

    public function login()
    {
        $this->validate();

        // Log la tentative de connexion
        Log::info('Tentative de connexion', ['email' => $this->email]);

        // Authentifier l'user
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            // Récupérer l'user authentifié
            $user = Auth::user();

            // Vérifier le rôle de l'user
            if ($user->role === 'administrateur') {
                return redirect()->intended('/admin');
            } elseif ($user->role === 'employer') {
                return redirect()->intended('/employee');
            }
        }

        // Si l'authentification échoue
        Log::warning('Échec de connexion', ['email' => $this->email]);
        throw ValidationException::withMessages([
            'email' => 'Les identifiants fournis sont incorrects.',
        ]);
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
