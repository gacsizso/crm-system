@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Valuták</h1>
    <!-- Keresőmező -->
    <form method="GET" action="{{ route('currencies.index') }}" class="mb-3">
        <input type="text" name="search" placeholder="Keresés név, kód..." value="{{ request('search') }}" class="form-control" />
    </form>
    <a href="{{ route('currencies.create') }}" class="btn btn-primary mb-3">Új valuta hozzáadása</a>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Név</th>
                    <th>Kód</th>
                    <th>Műveletek</th>
                </tr>
            </thead>
            <tbody>
                @forelse($currencies as $currency)
                    <tr>
                        <td>{{ $currency->name }}</td>
                        <td>{{ $currency->code }}</td>
                        <td>
                            <a href="{{ route('currencies.edit', $currency) }}" class="btn btn-warning btn-sm me-1" data-bs-toggle="tooltip" title="Szerkesztés">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('currencies.destroy', $currency) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm me-1" onclick="return confirm('Biztosan törlöd?')" data-bs-toggle="tooltip" title="Törlés">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">
                            @if(request('search'))
                                Nincs találat a keresésre.
                            @else
                                Nincs még valuta rögzítve.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
        {{ $currencies->links() }}
    </div>
</div>
@endsection 