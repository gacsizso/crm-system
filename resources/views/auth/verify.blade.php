@extends('layouts.auth')
@section('title', 'E-mail megerősítése')
@section('content')
<h2 class="mb-4 fw-bold">E-mail megerősítése</h2>
@if (session('resent'))
    <div class="alert alert-success">Új megerősítő linket küldtünk az e-mail címedre.</div>
@endif
<p class="mb-3">Kérjük, ellenőrizd az e-mail fiókodat, és kattints a megerősítő linkre a folytatáshoz.</p>
<p>Nem kaptál e-mailt?</p>
<form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
    @csrf
    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">Kattints ide új kéréshez!</button>
</form>
@endsection
