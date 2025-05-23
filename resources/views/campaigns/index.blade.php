@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Kampányok</h1>
    <!-- Keresőmező -->
    <form method="GET" action="{{ route('campaigns.index') }}" class="mb-3">
        <input type="text" name="search" placeholder="Keresés tárgy, csoport, létrehozó..." value="{{ request('search') }}" class="form-control" />
    </form>
    <a href="{{ route('campaigns.create') }}" class="btn btn-primary mb-3">Új kampány hozzáadása</a>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tárgy</th>
                    <th>Csoportok</th>
                    <th>Elküldve?</th>
                    <th>Létrehozó</th>
                    <th>Létrehozva</th>
                    <th>Műveletek</th>
                </tr>
            </thead>
            <tbody>
                @forelse($campaigns as $campaign)
                    <tr>
                        <td class="truncate" title="{{ $campaign->subject }}">{{ $campaign->subject }}</td>
                        <td>
                            @foreach($campaign->groups as $group)
                                <span class="badge bg-info">{{ $group->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            @if($campaign->sent)
                                <span class="badge bg-success">Igen</span>
                            @else
                                <span class="badge bg-danger">Nem</span>
                            @endif
                        </td>
                        <td>{{ $campaign->creator->name ?? '-' }}</td>
                        <td>{{ $campaign->created_at ? \Carbon\Carbon::parse($campaign->created_at)->format('Y. m. d. H:i') : '-' }}</td>
                        <td>
                            <a href="{{ route('campaigns.preview', $campaign) }}" class="btn btn-outline-secondary btn-sm me-1" target="_blank" data-bs-toggle="tooltip" title="E-mail előnézet">
                                <i class="bi bi-envelope-open"></i>
                            </a>
                            @if(!$campaign->sent)
                                <form action="{{ route('campaigns.send', $campaign) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-success btn-sm me-1" data-bs-toggle="tooltip" title="E-mail küldése">
                                        <i class="bi bi-send"></i>
                                    </button>
                                </form>
                                <a href="{{ route('campaigns.edit', $campaign) }}" class="btn btn-warning btn-sm me-1" data-bs-toggle="tooltip" title="Szerkesztés">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('campaigns.destroy', $campaign) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm me-1" onclick="return confirm('Biztosan törlöd?')" data-bs-toggle="tooltip" title="Törlés">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            @if(request('search'))
                                Nincs találat a keresésre.
                            @else
                                Nincs még kampány rögzítve.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
        {{ $campaigns->links() }}
    </div>
</div>
@endsection 