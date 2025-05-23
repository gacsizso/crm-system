@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Csoportok</h1>
    <a href="{{ route('groups.create') }}" class="btn btn-primary mb-3">Új csoport hozzáadása</a>
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
            @foreach($groups as $group)
                <tr>
                    <td>{{ $group->name }}</td>
                    <td>{{ $group->description }}</td>
                    <td>{{ $group->clients->count() }}</td>
                    <td>
                        <a href="{{ route('groups.show', $group) }}" class="btn btn-info btn-sm">Részletek</a>
                        @can('update', $group)
                        <a href="{{ route('groups.edit', $group) }}" class="btn btn-warning btn-sm">Szerkesztés</a>
                        @endcan
                        @can('delete', $group)
                        <form action="{{ route('groups.destroy', $group) }}" method="POST" style="display:inline;">
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
    {{ $groups->links() }}
</div>
@endsection 