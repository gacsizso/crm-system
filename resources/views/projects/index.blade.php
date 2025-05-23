@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Projektek</h1>
    <div class="mb-3">
        @foreach($statuses as $key => $label)
            <a href="{{ route('projects.index', ['status' => $key]) }}" class="btn btn{{ (isset($status) && $status == $key) ? '-primary' : '-outline-primary' }} me-1">
                {{ $label }}
            </a>
        @endforeach
        <a href="{{ route('projects.index') }}" class="btn btn{{ empty($status) ? '-primary' : '-outline-primary' }} ms-2">Összes</a>
    </div>
    <a href="{{ route('projects.create') }}" class="btn btn-primary mb-3">Új projekt hozzáadása</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Név</th>
                <th>Státusz</th>
                <th>Kezdés</th>
                <th>Befejezés</th>
                <th>Ügyfelek száma</th>
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
                    <td>{{ $project->clients->count() }}</td>
                    <td>
                        <a href="{{ route('projects.show', $project) }}" class="btn btn-info btn-sm">Részletek</a>
                        @can('update', $project)
                        <a href="{{ route('projects.edit', $project) }}" class="btn btn-warning btn-sm">Szerkesztés</a>
                        @endcan
                        @can('delete', $project)
                        <form action="{{ route('projects.destroy', $project) }}" method="POST" style="display:inline;">
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
    {{ $projects->links() }}
</div>
@endsection 