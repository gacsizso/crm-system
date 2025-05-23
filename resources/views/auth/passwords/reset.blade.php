@extends('layouts.auth')
@section('title', 'Jelszó visszaállítása')
@section('content')
<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <h2 class="mb-4 fw-bold">Jelszó visszaállítása</h2>
    <div class="mb-3">
        <label for="email" class="form-label">E-mail cím</label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autofocus>
        @error('email')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Új jelszó</label>
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
        @error('password')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="password-confirm" class="form-label">Új jelszó megerősítése</label>
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
    </div>
    <div class="d-grid mb-3">
        <button type="submit" class="btn btn-primary btn-lg">Jelszó visszaállítása</button>
    </div>
    <div class="text-center">
        <a href="{{ route('login') }}">Vissza a bejelentkezéshez</a>
    </div>
</form>
@endsection
