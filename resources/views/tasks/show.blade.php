@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Feladat részletei</h1>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">{{ $task->name }}</h5>
            <p class="card-text"><strong>Leírás:</strong> {{ $task->description ?? '-' }}</p>
            <p class="card-text"><strong>Státusz:</strong> {{ $task->status }}</p>
            <p class="card-text"><strong>Projekt:</strong> {{ $task->project->name ?? '-' }}</p>
            <p class="card-text"><strong>Hozzárendelt felhasználó:</strong> {{ $task->assignedUser->name ?? '-' }}</p>
            <p class="card-text"><strong>Határidő:</strong> {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y. m. d.') : '-' }}</p>
            <p class="card-text"><strong>Létrehozta:</strong> {{ $task->creator->name ?? '-' }}</p>
            <p class="card-text"><strong>Létrehozás dátuma:</strong> {{ $task->created_at ? $task->created_at->format('Y. m. d. H:i') : '-' }}</p>
        </div>
    </div>
    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Vissza a feladatokhoz</a>
    @can('update', $task)
    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning ms-2">Szerkesztés</a>
    @endcan
</div>
@endsection 