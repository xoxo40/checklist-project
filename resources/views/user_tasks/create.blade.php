@extends('layouts.app')

@section('content')
    <h1>Créer une Tâche</h1>

    <form action="{{ route('user_tasks.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="task_details">Détails de la tâche</label>
            <input type="text" name="task_details" id="task_details" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="is_completed">Complétée ?</label>
            <input type="checkbox" name="is_completed" id="is_completed">
        </div>
        <button type="submit" class="btn btn-success">Créer</button>
    </form>
@endsection
