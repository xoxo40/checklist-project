@extends('layouts.app')

@section('content')
    <h1>Checklist des Tâches</h1>
    <livewire:user-task-checklist :userId="auth()->user()->id" />
@endsection
