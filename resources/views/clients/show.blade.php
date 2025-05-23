@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ügyfél részletei</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $client->name }}</h5>
            <p><strong>E-mail:</strong> {{ $client->email }}</p>
            <p><strong>Telefonszám:</strong> {{ $client->phone }}</p>
            <p><strong>Cím:</strong> {{ $client->address }}</p>
            <p><strong>Típus:</strong> {{ $client->type }}</p>
            <p><strong>Megjegyzés:</strong> {{ $client->notes }}</p>
            @can('update', $client)
            <a href="{{ route('clients.edit', $client) }}" class="btn btn-warning">Szerkesztés</a>
            @endcan
            @can('delete', $client)
            <form action="{{ route('clients.destroy', $client) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Biztosan törlöd?')">Törlés</button>
            </form>
            @endcan
            <a href="{{ route('clients.index') }}" class="btn btn-secondary">Vissza</a>
        </div>
    </div>
    <h2 class="mt-4">Kapcsolattartók</h2>
    <a href="{{ route('contacts.create', ['client_id' => $client->id]) }}" class="btn btn-primary mb-2">Új kapcsolattartó hozzáadása ehhez az ügyfélhez</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Név</th>
                <th>E-mail</th>
                <th>Telefonszám</th>
                <th>Pozíció</th>
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
    <h2 class="mt-4">Projektek</h2>
    <a href="{{ route('projects.create', ['client_id' => $client->id]) }}" class="btn btn-primary mb-2">Új projekt hozzáadása ehhez az ügyfélhez</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Név</th>
                <th>Státusz</th>
                <th>Kezdés</th>
                <th>Befejezés</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            @foreach($projects as $project)
                <tr>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->status }}</td>
                    <td>{{ $project->start_date }}</td>
                    <td>{{ $project->end_date }}</td>
                    <td>
                        <a href="{{ route('projects.show', $project) }}" class="btn btn-info btn-sm">Részletek</a>
                    </td>
                </tr>
                @if($project->tasks && $project->tasks->count())
                <tr>
                    <td colspan="5">
                        <strong>Feladatok:</strong>
                        <ul>
                            @foreach($project->tasks as $task)
                                <li>{{ $task->name }} ({{ $task->status }})</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
@endsection 