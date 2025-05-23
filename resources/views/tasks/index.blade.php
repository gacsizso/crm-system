@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Feladatok</h1>
    <div class="mb-3">
        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary @if(!request('mine')) active @endif">Összes feladat</a>
        <a href="{{ route('tasks.index', ['mine' => 1]) }}" class="btn btn-outline-primary @if(request('mine')) active @endif">Saját feladataim</a>
    </div>
    <!-- Keresőmező -->
    <form method="GET" action="{{ route('tasks.index') }}" class="mb-3">
        <input type="text" name="search" placeholder="Keresés név, státusz, projekt..." value="{{ request('search') }}" class="form-control" />
        @if(request('mine'))
            <input type="hidden" name="mine" value="1">
        @endif
    </form>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Új feladat hozzáadása</a>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Név</th>
                    <th>Projekt</th>
                    <th>Státusz</th>
                    <th>Határidő</th>
                    <th>Hozzárendelt</th>
                    @php
                        $showActions = $tasks->some(fn($task) => auth()->user() && (auth()->user()->can('update', $task) || auth()->user()->can('delete', $task)));
                    @endphp
                    @if($showActions)
                    <th>Műveletek</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $task)
                    <tr>
                        <td class="truncate" title="{{ $task->name }}">{{ $task->name }}</td>
                        <td>{{ $task->project->name ?? '-' }}</td>
                        <td>{{ $task->status }}</td>
                        <td>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y. m. d.') : '-' }}</td>
                        <td>{{ $task->assignedUser->name ?? '-' }}</td>
                        @if($showActions)
                        <td>
                            <a href="{{ route('tasks.show', $task) }}" class="btn btn-info btn-sm me-1" data-bs-toggle="tooltip" title="Részletek">
                                <i class="bi bi-eye"></i>
                            </a>
                            @can('update', $task)
                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning btn-sm me-1" data-bs-toggle="tooltip" title="Szerkesztés">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @endcan
                            @can('delete', $task)
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm me-1" onclick="return confirm('Biztosan törlöd?')" data-bs-toggle="tooltip" title="Törlés">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endcan
                            @if($task->status !== 'teljesítve')
                                <form action="{{ route('tasks.changeStatus', $task) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="teljesítve">
                                    <button type="submit" class="btn btn-success btn-sm me-1" data-bs-toggle="tooltip" title="Teljesítés">
                                        <i class="bi bi-check2-circle"></i>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('tasks.changeStatus', $task) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="folyamatban">
                                    <button type="submit" class="btn btn-secondary btn-sm me-1" data-bs-toggle="tooltip" title="Visszaaktiválás">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $showActions ? 6 : 5 }}" class="text-center">
                            @if(request('search'))
                                Nincs találat a keresésre.
                            @else
                                Nincs még feladat rögzítve.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
        {{ $tasks->links() }}
    </div>
</div>
@endsection 