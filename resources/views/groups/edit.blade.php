@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Csoport szerkesztése</h1>
    <form action="{{ route('groups.update', $group) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Név</label>
            <input type="text" name="name" class="form-control" value="{{ $group->name }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Leírás</label>
            <textarea name="description" class="form-control">{{ $group->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="clients" class="form-label">Ügyfelek</label>
            <select name="clients[]" class="form-control" multiple>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" @if($group->clients->contains($client->id)) selected @endif>{{ $client->name }}</option>
                @endforeach
            </select>
            <small class="form-text text-muted">Tartsd lenyomva a Ctrl (Windows) vagy Command (Mac) billentyűt több ügyfél kiválasztásához.</small>
        </div>
        <button type="submit" class="btn btn-success">Mentés</button>
        <a href="{{ route('groups.index') }}" class="btn btn-secondary">Vissza</a>
    </form>
</div>
@endsection 