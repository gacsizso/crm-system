@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Alkalmazottak</h1>
    <!-- Keresőmező -->
    <form method="GET" action="{{ route('users.index') }}" class="mb-3">
        <input type="text" name="search" placeholder="Keresés név, e-mail, szerepkör..." value="{{ request('search') }}" class="form-control" />
    </form>
    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Új alkalmazott hozzáadása</a>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kép</th>
                    <th>Név</th>
                    <th>E-mail</th>
                    <th>Szerepkör</th>
                    <th>Műveletek</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            @if($user->profile_image)
                                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profilkép" width="40" height="40" style="object-fit:cover; border-radius:50%;">
                            @else
                                <span class="text-muted">Nincs</span>
                            @endif
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>
                            @can('update', $user)
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm me-1" data-bs-toggle="tooltip" title="Szerkesztés">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @endcan
                            @can('delete', $user)
                            <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;">
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
                        <td colspan="5" class="text-center">
                            @if(request('search'))
                                Nincs találat a keresésre.
                            @else
                                Nincs még alkalmazott rögzítve.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
        {{ $users->links() }}
    </div>
</div>
@endsection 