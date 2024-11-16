@extends('layouts.app')

@section('content')
    <h1>Modifier la Tâche</h1>

    <form action="{{ route('user_tasks.update', $userTask->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="task_details">Détails de la tâche</label>
            <input type="text" name="task_details" id="task_details" class="form-control" value="{{ $userTask->task_details }}" required>
        </div>
        <div class="form-group">
            <label for="is_completed">Complétée ?</label>
            <input type="checkbox" name="is_completed" id="is_completed" {{ $userTask->is_completed ? 'checked' : '' }}>
        </div>
        <button type="submit" class="btn btn-success">Mettre à jour</button>
    </form>
@endsection
