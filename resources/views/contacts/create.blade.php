@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Új kapcsolattartó hozzáadása</h1>
    <form action="{{ route('contacts.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Név</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" name="email" class="form-control">
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Telefonszám</label>
            <input type="text" name="phone" class="form-control">
        </div>
        <div class="mb-3">
            <label for="position" class="form-label">Pozíció</label>
            <input type="text" name="position" class="form-control">
        </div>
        <div class="mb-3">
            <label for="notes" class="form-label">Megjegyzés</label>
            <textarea name="notes" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Mentés</button>
        <a href="{{ route('contacts.index') }}" class="btn btn-secondary">Vissza</a>
    </form>
</div>
@endsection 