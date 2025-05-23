@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Csoport részletei</h1>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">{{ $group->name }}</h5>
            <p><strong>Leírás:</strong> {{ $group->description }}</p>
            @can('update', $group)
            <a href="{{ route('groups.edit', $group) }}" class="btn btn-warning">Szerkesztés</a>
            @endcan
            @can('delete', $group)
            <form action="{{ route('groups.destroy', $group) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Biztosan törlöd?')">Törlés</button>
            </form>
            @endcan
            <a href="{{ route('groups.index') }}" class="btn btn-secondary">Vissza</a>
        </div>
    </div>
    <h2>Ügyfelek a csoportban</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Név</th>
                <th>E-mail</th>
                <th>Telefonszám</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            @foreach($group->clients as $client)
                <tr>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->phone }}</td>
                    <td>
                        <a href="{{ route('clients.show', $client) }}" class="btn btn-info btn-sm">Részletek</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 