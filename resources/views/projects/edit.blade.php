@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Projekt szerkesztése</h1>
    <form action="{{ route('projects.update', $project) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Név</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $project->name) }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Leírás</label>
            <textarea name="description" class="form-control">{{ old('description', $project->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Státusz</label>
            <select name="status" class="form-control">
                <option value="árajánlat" {{ old('status', $project->status) == 'árajánlat' ? 'selected' : '' }}>Árajánlat</option>
                <option value="értékesítés" {{ old('status', $project->status) == 'értékesítés' ? 'selected' : '' }}>Értékesítés</option>
                <option value="sikeres" {{ old('status', $project->status) == 'sikeres' ? 'selected' : '' }}>Sikeresen lezárt</option>
                <option value="sikertelen" {{ old('status', $project->status) == 'sikertelen' ? 'selected' : '' }}>Sikertelenül lezárt</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="start_date" class="form-label">Kezdés dátuma</label>
            <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $project->start_date) }}">
        </div>
        <div class="mb-3">
            <label for="end_date" class="form-label">Befejezés dátuma</label>
            <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $project->end_date) }}">
        </div>
        <div class="mb-3">
            <label for="deadline" class="form-label">Határidő</label>
            <input type="date" name="deadline" class="form-control" value="{{ old('deadline', $project->deadline) }}">
        </div>
        <div class="mb-3">
            <label for="hourly_rate" class="form-label">Munkaórák ára</label>
            <input type="number" step="0.01" name="hourly_rate" class="form-control" value="{{ old('hourly_rate', $project->hourly_rate) }}">
        </div>
        <div class="mb-3">
            <label for="hours" class="form-label">Munkaórák száma</label>
            <input type="number" name="hours" class="form-control" value="{{ old('hours', $project->hours) }}">
        </div>
        <div class="mb-3">
            <label for="currency" class="form-label">Valuta</label>
            <select name="currency" class="form-control">
                @foreach($currencies as $currency)
                    <option value="{{ $currency }}" {{ old('currency', $project->currency) == $currency ? 'selected' : '' }}>{{ $currency }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="note" class="form-label">Megjegyzés</label>
            <textarea name="note" class="form-control">{{ old('note', $project->note) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="contact_id" class="form-label">Ügyfél-kapcsolattartó</label>
            <select name="contact_id" class="form-control">
                <option value="">-- Válassz kapcsolattartót --</option>
                @foreach($contacts as $contact)
                    <option value="{{ $contact->id }}" {{ old('contact_id', $project->contact_id) == $contact->id ? 'selected' : '' }}>{{ $contact->name }} ({{ $contact->client->name ?? '' }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="group_id" class="form-label">Csoport</label>
            <select name="group_id" class="form-control">
                <option value="">-- Válassz csoportot --</option>
                @foreach($groups as $group)
                    <option value="{{ $group->id }}" {{ old('group_id', $project->group_id) == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="manager_id" class="form-label">Projektmenedzser</label>
            <select name="manager_id" class="form-control">
                <option value="">-- Válassz projektmenedzsert --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('manager_id', $project->manager_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="clients" class="form-label">Ügyfelek</label>
            <select name="clients[]" class="form-control" multiple>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ in_array($client->id, old('clients', $project->clients->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $client->name }}</option>
                @endforeach
            </select>
            <small class="form-text text-muted">Tartsd lenyomva a Ctrl (Windows) vagy Command (Mac) billentyűt több ügyfél kiválasztásához.</small>
        </div>
        <button type="submit" class="btn btn-success">Mentés</button>
        <a href="{{ route('projects.index') }}" class="btn btn-secondary">Vissza</a>
    </form>
</div>
@endsection 