@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Új projekt hozzáadása</h1>
    <form action="{{ route('projects.store') }}" method="POST">
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
            <label for="status" class="form-label">Státusz</label>
            <select name="status" class="form-control">
                <option value="árajánlat">Árajánlat</option>
                <option value="értékesítés">Értékesítés</option>
                <option value="sikeres">Sikeresen lezárt</option>
                <option value="sikertelen">Sikertelenül lezárt</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="start_date" class="form-label">Kezdés dátuma</label>
            <input type="date" name="start_date" class="form-control">
        </div>
        <div class="mb-3">
            <label for="end_date" class="form-label">Befejezés dátuma</label>
            <input type="date" name="end_date" class="form-control">
        </div>
        <div class="mb-3">
            <label for="deadline" class="form-label">Határidő</label>
            <input type="date" name="deadline" class="form-control">
        </div>
        <div class="mb-3">
            <label for="hourly_rate" class="form-label">Munkaórák ára</label>
            <input type="number" step="0.01" name="hourly_rate" class="form-control">
        </div>
        <div class="mb-3">
            <label for="hours" class="form-label">Munkaórák száma</label>
            <input type="number" name="hours" class="form-control">
        </div>
        <div class="mb-3">
            <label for="currency" class="form-label">Valuta</label>
            <select name="currency" class="form-control">
                @foreach($currencies as $currency)
                    <option value="{{ $currency }}">{{ $currency }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="note" class="form-label">Megjegyzés</label>
            <textarea name="note" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label for="contact_id" class="form-label">Ügyfél-kapcsolattartó</label>
            <select name="contact_id" class="form-control">
                <option value="">-- Válassz kapcsolattartót --</option>
                @foreach($contacts as $contact)
                    <option value="{{ $contact->id }}">{{ $contact->name }} ({{ $contact->client->name ?? '' }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="group_id" class="form-label">Csoport</label>
            <select name="group_id" class="form-control">
                <option value="">-- Válassz csoportot --</option>
                @foreach($groups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="manager_id" class="form-label">Projektmenedzser</label>
            <select name="manager_id" class="form-control">
                <option value="">-- Válassz projektmenedzsert --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="clients" class="form-label">Ügyfelek</label>
            <select name="clients[]" class="form-control" multiple>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach
            </select>
            <small class="form-text text-muted">Tartsd lenyomva a Ctrl (Windows) vagy Command (Mac) billentyűt több ügyfél kiválasztásához.</small>
        </div>
        <button type="submit" class="btn btn-success">Mentés</button>
        <a href="{{ route('projects.index') }}" class="btn btn-secondary">Vissza</a>
    </form>
</div>
@endsection 