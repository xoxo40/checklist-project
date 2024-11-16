@extends('layouts.app')

@section('content')
    <h1>Détails de la Tâche</h1>

    <p><strong>ID:</strong> {{ $userTask->id }}</p>
    <p><strong>Détails:</strong> {{ $userTask->task_details }}</p>
    <p><strong>Statut:</strong> {{ $userTask->is_completed ? 'Complétée' : 'En cours' }}</p>
    <p><strong>Commentaire:</strong> {{ $userTask->commentaire }}</p>

    <a href="{{ route('user_tasks.index') }}" class="btn btn-primary">Retour à la liste</a>
@endsection
