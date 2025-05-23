@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Alkalmazottak</h1>
    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Új alkalmazott hozzáadása</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Profilkép</th>
                <th>Név</th>
                <th>E-mail</th>
                <th>Szerepkör</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
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
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">Szerkesztés</a>
                        @endcan
                        @can('delete', $user)
                        <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Biztosan törlöd?')">Törlés</button>
                        </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
</div>
@endsection 