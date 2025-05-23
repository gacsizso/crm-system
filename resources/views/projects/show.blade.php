@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Projekt részletei</h1>
    <div class="mb-3">
        <strong>Név:</strong> {{ $project->name }}
    </div>
    <div class="mb-3">
        <strong>Leírás:</strong> {{ $project->description }}
    </div>
    <div class="mb-3">
        <strong>Státusz:</strong> {{ $project->status }}
    </div>
    <!-- Folyamat vizualizáció: státusz lépésjelző -->
    <div class="mb-4">
        @php
            $statuses = ['árajánlat' => 'Árajánlat', 'értékesítés' => 'Értékesítés', 'sikeres' => 'Sikeresen lezárt', 'sikertelen' => 'Sikertelenül lezárt'];
            $current = array_search($project->status, array_keys($statuses));
        @endphp
        <div class="d-flex justify-content-between align-items-center" style="max-width:600px;margin:auto;">
            @foreach($statuses as $key => $label)
                <div class="text-center flex-fill">
                    <div style="width:36px;height:36px;line-height:36px;border-radius:50%;background:{{ $project->status == $key ? '#0d6efd' : '#dee2e6' }};color:{{ $project->status == $key ? '#fff' : '#495057' }};margin:auto;font-weight:bold;">{{ $loop->iteration }}</div>
                    <div style="margin-top:8px;font-size:14px;{{ $project->status == $key ? 'font-weight:bold;color:#0d6efd;' : '' }}">{{ $label }}</div>
                </div>
                @if(!$loop->last)
                    <div style="height:4px;background:#dee2e6;flex:1;margin:0 4px;position:relative;top:-16px;"></div>
                @endif
            @endforeach
        </div>
    </div>
    <div class="mb-3">
        <strong>Kezdés dátuma:</strong> {{ $project->start_date }}
    </div>
    <div class="mb-3">
        <strong>Befejezés dátuma:</strong> {{ $project->end_date }}
    </div>
    <div class="mb-3">
        <strong>Kapcsolódó ügyfelek:</strong>
        <ul>
            @foreach($project->clients as $client)
                <li>{{ $client->name }}</li>
            @endforeach
        </ul>
    </div>
    <div class="mb-3">
        <a href="{{ route('projects.index') }}" class="btn btn-secondary">Vissza</a>
        @can('update', $project)
        <a href="{{ route('projects.edit', $project) }}" class="btn btn-warning">Szerkesztés</a>
        @endcan
        <a href="{{ route('projects.quote', $project) }}" class="btn btn-outline-success" target="_blank">Árajánlat nyomtatása</a>
        @if(auth()->id() == $project->manager_id)
            <a href="{{ route('tasks.index', ['project_id' => $project->id]) }}" class="btn btn-outline-primary">Feladatok</a>
            <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" class="btn btn-outline-info">Feladat hozzáadása</a>
            <div class="mb-3">
                <form action="{{ route('projects.status', $project) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <label for="status" class="form-label">Státusz módosítása:</label>
                    <select name="status" id="status" class="form-select d-inline w-auto">
                        <option value="árajánlat" {{ $project->status == 'árajánlat' ? 'selected' : '' }}>Árajánlat</option>
                        <option value="értékesítés" {{ $project->status == 'értékesítés' ? 'selected' : '' }}>Értékesítés</option>
                        <option value="sikeres" {{ $project->status == 'sikeres' ? 'selected' : '' }}>Sikeresen lezárt</option>
                        <option value="sikertelen" {{ $project->status == 'sikertelen' ? 'selected' : '' }}>Sikertelenül lezárt</option>
                    </select>
                    <button type="submit" class="btn btn-primary ms-2">Mentés</button>
                </form>
            </div>
            @if(in_array($project->status, ['sikeres', 'sikertelen']))
            <form action="{{ route('projects.status', $project) }}" method="POST" class="d-inline mt-2">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="értékesítés">
                <button type="submit" class="btn btn-outline-warning">Újranyitás (értékesítés státuszba)</button>
            </form>
            @endif
        @endif
    </div>
</div>
@endsection 