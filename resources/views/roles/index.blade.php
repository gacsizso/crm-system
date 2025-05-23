@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Szerepkörök</h1>
    <!-- Keresőmező -->
    <form method="GET" action="{{ route('roles.index') }}" class="mb-3">
        <input type="text" name="search" placeholder="Keresés név, leírás, jogosultság..." value="{{ request('search') }}" class="form-control" />
    </form>
    <a href="{{ route('roles.create') }}" class="btn btn-primary mb-3">Új szerepkör hozzáadása</a>
    <div class="table-responsive">
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
                @forelse($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->description }}</td>
                        <td>
                            @foreach($role->permissions as $permission)
                                <span class="badge bg-info">{{ $permission->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('roles.edit', $role) }}" class="btn btn-warning btn-sm me-1" data-bs-toggle="tooltip" title="Szerkesztés">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('roles.destroy', $role) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm me-1" onclick="return confirm('Biztosan törlöd?')" data-bs-toggle="tooltip" title="Törlés">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            @if(request('search'))
                                Nincs találat a keresésre.
                            @else
                                Nincs még szerepkör rögzítve.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
        {{ $roles->links() }}
    </div>
</div>
@endsection 