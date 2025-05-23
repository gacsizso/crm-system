@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Értesítések</h5>
                    <button class="btn btn-sm btn-outline-primary" onclick="markAllAsRead()">
                        Mindet olvasottnak jelöl
                    </button>
                </div>

                <div class="card-body">
                    @forelse($notifications as $notification)
                        <div class="notification-item p-3 border-bottom {{ $notification->is_read ? 'bg-light' : 'bg-white' }}" 
                             id="notification-{{ $notification->id }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">{{ $notification->title }}</h6>
                                    <p class="mb-1">{{ $notification->message }}</p>
                                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                                @if(!$notification->is_read)
                                    <button class="btn btn-sm btn-outline-primary" 
                                            onclick="markAsRead({{ $notification->id }})">
                                        Olvasottnak jelöl
                                    </button>
                                @endif
                            </div>
                            @if($notification->link)
                                <a href="{{ $notification->link }}" class="stretched-link"></a>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <p class="text-muted mb-0">Nincsenek értesítések</p>
                        </div>
                    @endforelse

                    <div class="mt-4">
                        {{ $notifications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function markAsRead(id) {
    fetch(`/notifications/${id}/mark-as-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            document.getElementById(`notification-${id}`).classList.add('bg-light');
            document.getElementById(`notification-${id}`).querySelector('button').remove();
            updateNotificationCount();
        }
    });
}

function markAllAsRead() {
    fetch('/notifications/mark-all-as-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            location.reload();
        }
    });
}

function updateNotificationCount() {
    fetch('/notifications/unread-count')
        .then(response => response.json())
        .then(data => {
            const badge = document.querySelector('.notification-badge');
            if(badge) {
                badge.textContent = data.count;
                if(data.count === 0) {
                    badge.style.display = 'none';
                }
            }
        });
}
</script>
@endpush
@endsection 