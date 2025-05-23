@extends('layouts.auth')
@section('title', 'Bejelentkezés')
@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf
    <h2 class="mb-4 fw-bold">Bejelentkezés</h2>
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
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
    <div class="mb-3 form-check">
        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
        <label class="form-check-label" for="remember">Emlékezz rám</label>
        <a class="float-end small" href="{{ route('password.request') }}">Elfelejtett jelszó?</a>
    </div>
    <div class="d-grid mb-3">
        <button type="submit" class="btn btn-primary btn-lg">Bejelentkezés</button>
    </div>
    <div class="text-center">
        <span class="text-muted">Nincs még fiókod?</span>
        <a href="{{ route('register') }}">Regisztrálj!</a>
    </div>
</form>
@endsection 