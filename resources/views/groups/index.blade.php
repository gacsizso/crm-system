@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Csoportok</h1>
    <!-- Keresőmező -->
    <form method="GET" action="{{ route('groups.index') }}" class="mb-3">
        <input type="text" name="search" placeholder="Keresés név, leírás..." value="{{ request('search') }}" class="form-control" />
    </form>
    <a href="{{ route('groups.create') }}" class="btn btn-primary mb-3">Új csoport hozzáadása</a>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Név</th>
                    <th>Leírás</th>
                    <th>Ügyfelek száma</th>
                    <th>Műveletek</th>
                </tr>
            </thead>
            <tbody>
                @forelse($groups as $group)
                    <tr>
                        <td>{{ $group->name }}</td>
                        <td>{{ $group->description }}</td>
                        <td>{{ $group->clients->count() }}</td>
                        <td>
                            <a href="{{ route('groups.show', $group) }}" class="btn btn-info btn-sm me-1" data-bs-toggle="tooltip" title="Részletek">
                                <i class="bi bi-eye"></i>
                            </a>
                            @can('update', $group)
                            <a href="{{ route('groups.edit', $group) }}" class="btn btn-warning btn-sm me-1" data-bs-toggle="tooltip" title="Szerkesztés">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @endcan
                            @can('delete', $group)
                            <form action="{{ route('groups.destroy', $group) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm me-1" onclick="return confirm('Biztosan törlöd?')" data-bs-toggle="tooltip" title="Törlés">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            @if(request('search'))
                                Nincs találat a keresésre.
                            @else
                                Nincs még csoport rögzítve.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
        {{ $groups->links() }}
    </div>
</div>
@endsection 