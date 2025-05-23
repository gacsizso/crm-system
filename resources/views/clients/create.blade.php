@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Új ügyfél hozzáadása</h1>
    <form action="{{ route('clients.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Név</label>
            <input type="text" name="name" class="form-control" required value="{{ request('name') }}">
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
            <label for="address" class="form-label">Cím</label>
            <input type="text" name="address" class="form-control">
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Típus</label>
            <select name="type" id="type" class="form-control" required>
                <option value="Céges">Céges</option>
                <option value="Magánszemély">Magánszemély</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="notes" class="form-label">Megjegyzés</label>
            <textarea name="notes" class="form-control"></textarea>
        </div>
        <hr>
        <button type="submit" class="btn btn-success">Mentés</button>
        <a href="{{ route('clients.index') }}" class="btn btn-secondary">Vissza</a>
    </form>
</div>
@endsection 