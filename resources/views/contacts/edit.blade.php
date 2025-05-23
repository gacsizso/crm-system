@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Kapcsolattartó szerkesztése</h1>
    <form action="{{ route('contacts.update', $contact) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="clients" class="form-label">Ügyfelek</label>
            <select name="clients[]" id="clients" class="form-control" multiple>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ $contact->clients->contains($client->id) ? 'selected' : '' }}>{{ $client->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Név</label>
            <input type="text" name="name" class="form-control" value="{{ $contact->name }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" name="email" class="form-control" value="{{ $contact->email }}">
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Telefonszám</label>
            <input type="text" name="phone" class="form-control" value="{{ $contact->phone }}">
        </div>
        <div class="mb-3">
            <label for="position" class="form-label">Pozíció</label>
            <input type="text" name="position" class="form-control" value="{{ $contact->position }}">
        </div>
        <div class="mb-3">
            <label for="notes" class="form-label">Megjegyzés</label>
            <textarea name="notes" class="form-control">{{ $contact->notes }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Mentés</button>
        <a href="{{ route('contacts.index') }}" class="btn btn-secondary">Vissza</a>
    </form>
</div>
@endsection 