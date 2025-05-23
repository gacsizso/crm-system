@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Kapcsolattartók</h1>
    <a href="{{ route('contacts.create') }}" class="btn btn-primary mb-3">Új kapcsolattartó hozzáadása</a>
    <form method="GET" action="{{ route('contacts.index') }}" class="mb-3">
        <input type="text" name="search" placeholder="Keresés név, e-mail, telefonszám..." value="{{ request('search') }}" class="form-control" />
    </form>
    <div class="table-responsive">
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
                            <a href="{{ route('contacts.show', $contact) }}" class="btn btn-info btn-sm me-1" data-bs-toggle="tooltip" title="Részletek">
                                <i class="bi bi-eye"></i>
                            </a>
                            @can('update', $contact)
                            <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-warning btn-sm me-1" data-bs-toggle="tooltip" title="Szerkesztés">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @endcan
                            @can('delete', $contact)
                            <form action="{{ route('contacts.destroy', $contact) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm me-1" onclick="return confirm('Biztosan törlöd?')" data-bs-toggle="tooltip" title="Törlés">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
        {{ $contacts->links() }}
    </div>
</div>
@endsection 