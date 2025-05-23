@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Kampányok</h1>
    <a href="{{ route('campaigns.create') }}" class="btn btn-primary mb-3">Új kampány hozzáadása</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tárgy</th>
                <th>Csoportok</th>
                <th>Elküldve?</th>
                <th>Létrehozó</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            @foreach($campaigns as $campaign)
                <tr>
                    <td>{{ $campaign->subject }}</td>
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
                    <td>
                        <a href="{{ route('campaigns.preview', $campaign) }}" class="btn btn-outline-secondary btn-sm" target="_blank">E-mail előnézet</a>
                        @if(!$campaign->sent)
                            <form action="{{ route('campaigns.send', $campaign) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-outline-success btn-sm">E-mail küldése</button>
                            </form>
                            <a href="{{ route('campaigns.edit', $campaign) }}" class="btn btn-warning btn-sm">Szerkesztés</a>
                            <form action="{{ route('campaigns.destroy', $campaign) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Biztosan törlöd?')">Törlés</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $campaigns->links() }}
</div>
@endsection 