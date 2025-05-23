@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Új feladat hozzáadása</h1>
    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Név</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Leírás</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label for="project_id" class="form-label">Projekt</label>
            <select name="project_id" class="form-control" required>
                <option value="">-- Válassz projektet --</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" {{ (isset($selectedProject) && $selectedProject == $project->id) ? 'selected' : '' }}>{{ $project->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="assigned_to" class="form-label">Hozzárendelt felhasználó</label>
            <select name="assigned_to" class="form-control">
                <option value="">-- Nincs hozzárendelve --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="due_date" class="form-label">Határidő</label>
            <input type="date" name="due_date" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Mentés</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Vissza</a>
    </form>
</div>
@endsection 