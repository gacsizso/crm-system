@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Kapcsolattartók</h1>
    <a href="{{ route('contacts.create') }}" class="btn btn-primary mb-3">Új kapcsolattartó hozzáadása</a>
    <form method="GET" action="{{ route('contacts.index') }}" class="mb-3">
        <input type="text" name="search" placeholder="Keresés név, e-mail, telefonszám..." value="{{ request('search') }}" class="form-control" />
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Név</th>
                <th>E-mail</th>
                <th>Telefonszám</th>
                <th>Pozíció</th>
                <th>Ügyfelek</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
                <tr>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->phone }}</td>
                    <td>{{ $contact->position }}</td>
                    <td>
                        @if($contact->clients->count())
                            {{ $contact->clients->pluck('name')->implode(', ') }}
                        @else
                            <span class="text-muted">Nincs</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('contacts.show', $contact) }}" class="btn btn-info btn-sm">Részletek</a>
                        @can('update', $contact)
                        <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-warning btn-sm">Szerkesztés</a>
                        @endcan
                        @can('delete', $contact)
                        <form action="{{ route('contacts.destroy', $contact) }}" method="POST" style="display:inline;">
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
    {{ $contacts->links() }}
</div>
@endsection 