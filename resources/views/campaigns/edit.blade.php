@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Kampány szerkesztése</h1>
    <form action="{{ route('campaigns.update', $campaign) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="subject" class="form-label">Tárgy</label>
            <input type="text" name="subject" class="form-control" value="{{ old('subject', $campaign->subject) }}" required>
        </div>
        <div class="mb-3">
            <label for="body" class="form-label">Szöveg (Markdown támogatott)</label>
            <textarea name="body" class="form-control" rows="8" required>{{ old('body', $campaign->body) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="groups" class="form-label">Csoportok</label>
            <select name="groups[]" class="form-control" multiple required>
                @foreach($groups as $group)
                    <option value="{{ $group->id }}" {{ in_array($group->id, $selectedGroups) ? 'selected' : '' }}>{{ $group->name }}</option>
                @endforeach
            </select>
            <small class="form-text text-muted">Tartsd lenyomva a Ctrl (Windows) vagy Command (Mac) billentyűt több csoport kiválasztásához.</small>
        </div>
        <button type="submit" class="btn btn-success">Mentés</button>
        <a href="{{ route('campaigns.index') }}" class="btn btn-secondary">Vissza</a>
    </form>
</div>
@endsection 