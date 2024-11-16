<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\UserTaskChecklist;

Route::get('/user-tasks', function () {
    return view('user-tasks.index');
})->name('user.tasks.index');



// Autres routes...
