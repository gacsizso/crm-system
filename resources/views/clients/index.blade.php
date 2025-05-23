@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ügyfelek</h1>
    <a href="{{ route('clients.create') }}" class="btn btn-primary mb-3">Új hozzáadása</a>
    <form method="GET" action="{{ route('clients.index') }}" class="mb-3">
        <input type="text" name="search" placeholder="Keresés név, e-mail, telefonszám..." value="{{ request('search') }}" class="form-control" />
    </form>
    <div class="table-responsive">
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
                            <a href="{{ route('clients.show', $client) }}" class="btn btn-info btn-sm me-1" data-bs-toggle="tooltip" title="Részletek">
                                <i class="bi bi-eye"></i>
                            </a>
                            @can('update', $client)
                            <a href="{{ route('clients.edit', $client) }}" class="btn btn-warning btn-sm me-1" data-bs-toggle="tooltip" title="Szerkesztés">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @endcan
                            @can('delete', $client)
                            <form action="{{ route('clients.destroy', $client) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm me-1" onclick="return confirm('Biztosan törlöd?')" data-bs-toggle="tooltip" title="Törlés">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endcan
                            <a href="#" class="btn btn-secondary btn-sm me-1" data-bs-toggle="tooltip" title="Árajánlatok"><i class="bi bi-file-earmark-text"></i></a>
                            <a href="#" class="btn btn-secondary btn-sm me-1" data-bs-toggle="tooltip" title="Értékesítés"><i class="bi bi-cash-coin"></i></a>
                            <a href="#" class="btn btn-secondary btn-sm me-1" data-bs-toggle="tooltip" title="Sikeres projektek"><i class="bi bi-check-circle"></i></a>
                            <a href="#" class="btn btn-secondary btn-sm me-1" data-bs-toggle="tooltip" title="Sikertelen projektek"><i class="bi bi-x-circle"></i></a>
                            <a href="#" class="btn btn-secondary btn-sm me-1" data-bs-toggle="tooltip" title="Kapcsolattartók"><i class="bi bi-person-lines-fill"></i></a>
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
    </div>
    <div class="d-flex justify-content-center">
        {{ $clients->links() }}
    </div>
</div>
@endsection 