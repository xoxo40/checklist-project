<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\UserTaskChecklist;
use App\Livewire\Auth\Login;

Route::get('/user-tasks', function () {
    return view('user-tasks.index');
})->name('user.tasks.index');

Route::get('login', Login::class)->name('login');



// Autres routes...
