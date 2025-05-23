@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Kapcsolattartó részletei</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $contact->name }}</h5>
            <p><strong>Ügyfelek:</strong> 
                @if($contact->clients && $contact->clients->count())
                    {{ $contact->clients->pluck('name')->implode(', ') }}
                @else
                    <span class="text-muted">Nincs</span>
                @endif
            </p>
            <p><strong>E-mail:</strong> {{ $contact->email }}</p>
            <p><strong>Telefonszám:</strong> {{ $contact->phone }}</p>
            <p><strong>Pozíció:</strong> {{ $contact->position }}</p>
            <p><strong>Megjegyzés:</strong> {{ $contact->notes }}</p>
            @can('update', $contact)
            <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-warning">Szerkesztés</a>
            @endcan
            @can('delete', $contact)
            <form action="{{ route('contacts.destroy', $contact) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Biztosan törlöd?')">Törlés</button>
            </form>
            @endcan
            <a href="{{ route('contacts.index') }}" class="btn btn-secondary">Vissza</a>
        </div>
    </div>
</div>
@endsection 