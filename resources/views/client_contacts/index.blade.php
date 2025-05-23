@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ügyfél-Kapcsolattartók hozzárendelése</h1>
    <form method="POST" action="{{ route('client-contacts.store') }}">
        @csrf
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Ügyfél</th>
                    <th>Kapcsolattartó</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                <tr>
                    <td>{{ $client->name }}</td>
                    <td>
                        <select name="contacts[{{ $client->id }}][]" class="form-control" multiple>
                            @foreach($contacts as $contact)
                                <option value="{{ $contact->id }}" {{ $client->contacts->contains($contact->id) ? 'selected' : '' }}>
                                    {{ $contact->name }} ({{ $contact->email }})
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Mentés</button>
    </form>
</div>
@endsection 