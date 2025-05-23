@extends('layouts.auth')
@section('title', 'Jelszó megerősítése')
@section('content')
<form method="POST" action="{{ route('password.confirm') }}">
    @csrf
    <h2 class="mb-4 fw-bold">Jelszó megerősítése</h2>
    <p class="mb-4">Kérjük, erősítse meg a jelszavát a folytatáshoz.</p>
    <div class="mb-3">
        <label for="password" class="form-label">Jelszó</label>
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autofocus>
        @error('password')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="d-grid mb-3">
        <button type="submit" class="btn btn-primary btn-lg">Megerősítés</button>
    </div>
    <div class="text-center">
        <a href="{{ route('password.request') }}">Elfelejtett jelszó?</a>
    </div>
</form>
@endsection
