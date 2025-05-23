@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Kampány e-mail előnézet</h1>
    <div class="mb-3">
        <strong>Tárgy:</strong> {{ $campaign->subject }}
    </div>
    <div class="card p-3 mb-3">
        {!! $html !!}
    </div>
    <a href="{{ route('campaigns.index') }}" class="btn btn-secondary">Vissza</a>
</div>
@endsection 