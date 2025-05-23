@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Szerepkörök</h1>
    <a href="{{ route('roles.create') }}" class="btn btn-primary mb-3">Új szerepkör hozzáadása</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Név</th>
                <th>Leírás</th>
                <th>Jogosultságok</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->description }}</td>
                    <td>
                        @foreach($role->permissions as $permission)
                            <span class="badge bg-info">{{ $permission->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('roles.edit', $role) }}" class="btn btn-warning btn-sm">Szerkesztés</a>
                        <form action="{{ route('roles.destroy', $role) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Biztosan törlöd?')">Törlés</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $roles->links() }}
</div>
@endsection 