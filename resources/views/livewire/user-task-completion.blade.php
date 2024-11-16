@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tâches à vérifier pour : {{ $userTask->employee->name }}</h1>
    <livewire:user-task-compilation :taskId="$task->id" />
    
    <form action="{{ route('user-task.update', $userTask->id) }}" method="POST">
        @csrf
        @method('PUT')

        @foreach ($tasks as $task)
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="task{{ $task->id }}" 
                       name="tasks[{{ $task->id }}]" {{ $task->is_completed ? 'checked' : '' }}>
                <label class="form-check-label" for="task{{ $task->id }}">
                    {{ $task->title }}
                </label>
            </div>
        @endforeach

        <div class="form-group">
            <label for="commentaire">Commentaire :</label>
            <textarea class="form-control" name="commentaire" id="commentaire">{{ $userTask->commentaire }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection
