@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Új szerepkör hozzáadása</h1>
    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Név</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Leírás</label>
            <input type="text" name="description" class="form-control">
        </div>
        <div class="mb-3">
            <label for="permissions" class="form-label">Jogosultságok</label>
            <select name="permissions[]" class="form-control" multiple>
                @foreach($permissions as $permission)
                    <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                @endforeach
            </select>
            <small class="form-text text-muted">Tartsd lenyomva a Ctrl (Windows) vagy Command (Mac) billentyűt több jogosultság kiválasztásához.</small>
        </div>
        <button type="submit" class="btn btn-success">Mentés</button>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Vissza</a>
    </form>
</div>
@endsection 