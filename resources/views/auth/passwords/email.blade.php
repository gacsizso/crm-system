@extends('layouts.auth')
@section('title', 'Elfelejtett jelszó')
@section('content')
<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <h2 class="mb-4 fw-bold">Elfelejtett jelszó</h2>
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    <div class="mb-3">
        <label for="email" class="form-label">E-mail cím</label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
        @error('email')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="d-grid mb-3">
        <button type="submit" class="btn btn-primary btn-lg">Jelszó visszaállító link küldése</button>
    </div>
    <div class="text-center">
        <a href="{{ route('login') }}">Vissza a bejelentkezéshez</a>
    </div>
</form>
@endsection
