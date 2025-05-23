@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ügyfelek</h1>
    <a href="{{ route('clients.create') }}" class="btn btn-primary mb-3">Új hozzáadása</a>
    <form method="GET" action="{{ route('clients.index') }}" class="mb-3">
        <input type="text" name="search" placeholder="Keresés név, e-mail, telefonszám..." value="{{ request('search') }}" class="form-control" />
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Név</th>
                <th>E-mail</th>
                <th>Telefonszám</th>
                <th>Típus</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
                <tr>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->phone }}</td>
                    <td>{{ $client->type }}</td>
                    <td>
                        <a href="{{ route('clients.show', $client) }}" class="btn btn-info btn-sm">Részletek</a>
                        @can('update', $client)
                        <a href="{{ route('clients.edit', $client) }}" class="btn btn-warning btn-sm">Szerkesztés</a>
                        @endcan
                        @can('delete', $client)
                        <form action="{{ route('clients.destroy', $client) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Biztosan törlöd?')">Törlés</button>
                        </form>
                        @endcan
                        <!-- Kapcsolódó adatok gombok helye -->
                        <a href="#" class="btn btn-secondary btn-sm">Árajánlatok</a>
                        <a href="#" class="btn btn-secondary btn-sm">Értékesítés</a>
                        <a href="#" class="btn btn-secondary btn-sm">Sikeres projektek</a>
                        <a href="#" class="btn btn-secondary btn-sm">Sikertelen projektek</a>
                        <a href="#" class="btn btn-secondary btn-sm">Kapcsolattartók</a>
                    </td>
                </tr>
            @endforeach
            @if($clients->isEmpty() && request('search'))
                <tr>
                    <td colspan="5" class="text-center">
                        Nincs találat a keresésre.<br>
                        <a href="{{ route('clients.create', ['name' => request('search')]) }}" class="btn btn-success mt-2">Új ügyfél rögzítése "{{ request('search') }}" névvel</a>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
    {{ $clients->links() }}
</div>
@endsection 