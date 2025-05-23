@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ügyfél szerkesztése</h1>
    <form action="{{ route('clients.update', $client) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Név</label>
            <input type="text" name="name" class="form-control" value="{{ $client->name }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" name="email" class="form-control" value="{{ $client->email }}">
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Telefonszám</label>
            <input type="text" name="phone" class="form-control" value="{{ $client->phone }}">
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Cím</label>
            <input type="text" name="address" class="form-control" value="{{ $client->address }}">
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Típus</label>
            <input type="text" name="type" class="form-control" value="{{ $client->type }}">
        </div>
        <div class="mb-3">
            <label for="notes" class="form-label">Megjegyzés</label>
            <textarea name="notes" class="form-control">{{ $client->notes }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Mentés</button>
        <a href="{{ route('clients.index') }}" class="btn btn-secondary">Vissza</a>
    </form>
</div>
@endsection 