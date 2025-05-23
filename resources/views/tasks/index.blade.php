@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Feladatok</h1>
    <div class="mb-3">
        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary @if(!request('mine')) active @endif">Összes feladat</a>
        <a href="{{ route('tasks.index', ['mine' => 1]) }}" class="btn btn-outline-primary @if(request('mine')) active @endif">Saját feladataim</a>
    </div>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Új feladat hozzáadása</a>
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
            @foreach($tasks as $task)
                <tr>
                    <td>{{ $task->name }}</td>
                    <td>{{ $task->project->name ?? '-' }}</td>
                    <td>{{ $task->status }}</td>
                    <td>{{ $task->due_date }}</td>
                    <td>{{ $task->assignedUser->name ?? '-' }}</td>
                    @if($showActions)
                    <td>
                        <a href="{{ route('tasks.show', $task) }}" class="btn btn-info btn-sm">Részletek</a>
                        @can('update', $task)
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning btn-sm">Szerkesztés</a>
                        @endcan
                        @can('delete', $task)
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Biztosan törlöd?')">Törlés</button>
                        </form>
                        @endcan
                        @if($task->status !== 'teljesítve')
                            <form action="{{ route('tasks.changeStatus', $task) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="teljesítve">
                                <button type="submit" class="btn btn-success btn-sm">Teljesítés</button>
                            </form>
                        @else
                            <form action="{{ route('tasks.changeStatus', $task) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="folyamatban">
                                <button type="submit" class="btn btn-secondary btn-sm">Visszaaktiválás</button>
                            </form>
                        @endif
                    </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $tasks->links() }}
</div>
@endsection 