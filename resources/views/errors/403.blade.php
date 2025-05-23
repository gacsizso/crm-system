@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <h1 class="display-4">403 - Hozzáférés megtagadva</h1>
    <p class="lead">Nincs jogosultságod a művelet végrehajtásához.</p>
    <a href="{{ url()->previous() }}" class="btn btn-primary mt-3">Vissza az előző oldalra</a>
</div>
@endsection 