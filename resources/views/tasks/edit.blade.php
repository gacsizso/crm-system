@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Feladat szerkesztése</h1>
    <form action="{{ route('tasks.update', $task) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Név</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $task->name) }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Leírás</label>
            <textarea name="description" class="form-control">{{ old('description', $task->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="project_id" class="form-label">Projekt</label>
            <select name="project_id" class="form-control" required>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" {{ old('project_id', $task->project_id) == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="assigned_to" class="form-label">Hozzárendelt felhasználó</label>
            <select name="assigned_to" class="form-control">
                <option value="">-- Nincs hozzárendelve --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('assigned_to', $task->assigned_to) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="due_date" class="form-label">Határidő</label>
            <input type="date" name="due_date" class="form-control" value="{{ old('due_date', $task->due_date) }}">
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Státusz</label>
            <select name="status" class="form-control">
                <option value="új" {{ old('status', $task->status) == 'új' ? 'selected' : '' }}>Új</option>
                <option value="folyamatban" {{ old('status', $task->status) == 'folyamatban' ? 'selected' : '' }}>Folyamatban</option>
                <option value="teljesítve" {{ old('status', $task->status) == 'teljesítve' ? 'selected' : '' }}>Teljesítve</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Mentés</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Vissza</a>
    </form>
</div>
@endsection 