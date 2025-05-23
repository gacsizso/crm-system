@extends('layouts.auth')
@section('title', 'Regisztráció')
@section('content')
<form method="POST" action="{{ route('register') }}">
    @csrf
    <h2 class="mb-4 fw-bold">Regisztráció</h2>
    <div class="mb-3">
        <label for="name" class="form-label">Név</label>
        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
        @error('name')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
        @error('email')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Jelszó</label>
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
        @error('password')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="password-confirm" class="form-label">Jelszó megerősítése</label>
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
    </div>
    <div class="d-grid mb-3">
        <button type="submit" class="btn btn-primary btn-lg">Regisztráció</button>
    </div>
    <div class="text-center">
        <span class="text-muted">Már van fiókod?</span>
        <a href="{{ route('login') }}">Bejelentkezés</a>
    </div>
</form>
@endsection 