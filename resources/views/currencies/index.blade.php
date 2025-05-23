@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Valuták</h1>
    <a href="{{ route('currencies.create') }}" class="btn btn-primary mb-3">Új valuta hozzáadása</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Név</th>
                <th>Kód</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            @foreach($currencies as $currency)
                <tr>
                    <td>{{ $currency->name }}</td>
                    <td>{{ $currency->code }}</td>
                    <td>
                        <a href="{{ route('currencies.edit', $currency) }}" class="btn btn-warning btn-sm">Szerkesztés</a>
                        <form action="{{ route('currencies.destroy', $currency) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Biztosan törlöd?')">Törlés</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $currencies->links() }}
</div>
@endsection 