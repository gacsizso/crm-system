@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Új valuta hozzáadása</h1>
    <form action="{{ route('currencies.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Név</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="code" class="form-label">Kód (3 betűs rövidítés)</label>
            <input type="text" name="code" class="form-control" maxlength="3" required>
        </div>
        <button type="submit" class="btn btn-success">Mentés</button>
        <a href="{{ route('currencies.index') }}" class="btn btn-secondary">Vissza</a>
    </form>
</div>
@endsection 