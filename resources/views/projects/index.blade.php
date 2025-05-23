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
    <!-- Keresőmező -->
    <form method="GET" action="{{ route('projects.index') }}" class="mb-3">
        <input type="text" name="search" placeholder="Keresés név, leírás, státusz..." value="{{ request('search') }}" class="form-control" />
        @if(request('status'))
            <input type="hidden" name="status" value="{{ request('status') }}">
        @endif
    </form>
    <a href="{{ route('projects.create') }}" class="btn btn-primary mb-3">Új projekt hozzáadása</a>
    <div class="table-responsive">
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
                @forelse($projects as $project)
                    <tr>
                        <td class="truncate" title="{{ $project->name }}">{{ $project->name }}</td>
                        <td>{{ $project->status }}</td>
                        <td>{{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('Y. m. d.') : '-' }}</td>
                        <td>{{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('Y. m. d.') : '-' }}</td>
                        <td>{{ $project->clients->count() }}</td>
                        <td>
                            <a href="{{ route('projects.show', $project) }}" class="btn btn-info btn-sm me-1" data-bs-toggle="tooltip" title="Részletek">
                                <i class="bi bi-eye"></i>
                            </a>
                            @can('update', $project)
                            <a href="{{ route('projects.edit', $project) }}" class="btn btn-warning btn-sm me-1" data-bs-toggle="tooltip" title="Szerkesztés">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @endcan
                            @can('delete', $project)
                            <form action="{{ route('projects.destroy', $project) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm me-1" onclick="return confirm('Biztosan törlöd?')" data-bs-toggle="tooltip" title="Törlés">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            @if(request('search'))
                                Nincs találat a keresésre.
                            @else
                                Nincs még projekt rögzítve.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
        {{ $projects->links() }}
    </div>
</div>
@endsection 