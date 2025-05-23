@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Valuta szerkesztése</h1>
    <form action="{{ route('currencies.update', $currency) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Név</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $currency->name) }}" required>
        </div>
        <div class="mb-3">
            <label for="code" class="form-label">Kód (3 betűs rövidítés)</label>
            <input type="text" name="code" class="form-control" maxlength="3" value="{{ old('code', $currency->code) }}" required>
        </div>
        <button type="submit" class="btn btn-success">Mentés</button>
        <a href="{{ route('currencies.index') }}" class="btn btn-secondary">Vissza</a>
    </form>
</div>
@endsection 