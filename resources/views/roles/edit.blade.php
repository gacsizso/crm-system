@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Szerepkör szerkesztése</h1>
    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Név</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $role->name) }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Leírás</label>
            <input type="text" name="description" id="description" class="form-control" value="{{ old('description', $role->description) }}">
        </div>
        <div class="mb-3">
            <label for="permissions" class="form-label">Jogosultságok</label>
            <select name="permissions[]" id="permissions" class="form-control" multiple>
                @foreach($permissions as $permission)
                    <option value="{{ $permission->id }}" @if(in_array($permission->id, $selectedPermissions)) selected @endif>
                        {{ $permission->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Mentés</button>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Mégse</a>
    </form>
</div>
@endsection 