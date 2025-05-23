<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM rendszer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { background: #f7f8fa; }
        .sidebar {
            min-height: 100vh;
            background: #232b3e;
            color: #fff;
            width: 240px;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
            transition: width 0.2s;
        }
        .sidebar .sidebar-header {
            padding: 24px 16px 12px 16px;
            font-size: 1.2rem;
            font-weight: bold;
            letter-spacing: 1px;
            background: #1a2032;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .sidebar .sidebar-user {
            padding: 16px 16px 8px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .sidebar .sidebar-user img {
            width: 38px; height: 38px; border-radius: 50%; object-fit: cover; border: 2px solid #fff;
        }
        .sidebar .sidebar-user .user-name {
            font-size: 1rem;
            font-weight: 500;
        }
        .sidebar .sidebar-menu {
            margin-top: 12px;
        }
        .sidebar .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #cfd8e3;
            padding: 10px 24px;
            text-decoration: none;
            font-size: 1rem;
            border-left: 3px solid transparent;
            transition: background 0.15s, color 0.15s, border-color 0.15s;
        }
        .sidebar .sidebar-menu a.active, .sidebar .sidebar-menu a:hover {
            background: #1a2032;
            color: #fff;
            border-left: 3px solid #0d6efd;
        }
        .sidebar .sidebar-menu .sidebar-profile {
            margin-top: 24px;
            border-top: 1px solid #2e3650;
            padding-top: 12px;
        }
        .main-content {
            margin-left: 240px;
            min-height: 100vh;
            padding: 0;
        }
        .topbar {
            height: 64px;
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0 32px;
            position: sticky;
            top: 0;
            z-index: 101;
        }
        .user-dropdown {
            position: relative;
            display: inline-block;
        }
        .user-dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            border: none;
            background: none;
            font-size: 1rem;
        }
        .user-dropdown-toggle img {
            width: 36px; height: 36px; border-radius: 50%; object-fit: cover;
        }
        .user-dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 110%;
            background: #fff;
            min-width: 180px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.13);
            border-radius: 8px;
            overflow: hidden;
            z-index: 999;
        }
        .user-dropdown.open .user-dropdown-menu {
            display: block;
        }
        .user-dropdown-menu a {
            display: block;
            padding: 12px 20px;
            color: #232b3e;
            text-decoration: none;
            font-size: 1rem;
            transition: background 0.15s;
        }
        .user-dropdown-menu a:hover {
            background: #f1f3f7;
        }
        .notification-dropdown {
            position: relative;
        }
        .notification-dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background: #fff;
            min-width: 300px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.13);
            border-radius: 8px;
            overflow: hidden;
            z-index: 999;
        }
        .notification-dropdown.open .notification-dropdown-menu {
            display: block;
        }
        .notification-item {
            padding: 12px;
            border-bottom: 1px solid #eee;
            transition: background 0.15s;
        }
        .notification-item:hover {
            background: #f8f9fa;
        }
        .notification-item.unread {
            background: #f0f7ff;
        }
        .notification-item .notification-title {
            font-weight: 500;
            margin-bottom: 4px;
        }
        .notification-item .notification-time {
            font-size: 0.875rem;
            color: #6c757d;
        }
        .theme-dark {
            background: #181a1b !important;
            color: #e5e7eb !important;
        }
        .theme-dark .card, .theme-dark .sidebar, .theme-dark .topbar, .theme-dark .dropdown-menu, .theme-dark .notification-dropdown-menu {
            background: #232b3e !important;
            color: #e5e7eb !important;
        }
        .theme-dark .sidebar-user .user-name,
        .theme-dark .user-dropdown-toggle span {
            color: #fff !important;
        }
        .theme-dark .sidebar-menu a,
        .theme-dark .sidebar-menu a i {
            color: #cfd8e3 !important;
            transition: color 0.2s, background 0.2s;
        }
        .theme-dark .sidebar-menu a.active, .theme-dark .sidebar-menu a:hover {
            background: #1a2032 !important;
            color: #fff !important;
            transition: color 0.2s, background 0.2s;
        }
        .theme-dark .form-control, .theme-dark .form-select, .theme-dark input, .theme-dark textarea {
            background: #232b3e !important;
            color: #e5e7eb !important;
            border-color: #444c5e;
            transition: background 0.2s, color 0.2s;
        }
        .theme-dark .form-control:focus, .theme-dark .form-select:focus, .theme-dark input:focus, .theme-dark textarea:focus {
            background: #232b3e !important;
            color: #fff !important;
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13,110,253,.15);
        }
        .theme-dark .form-label, .theme-dark label, .theme-dark .text-muted {
            color: #b0b3b8 !important;
        }
        .theme-dark ::placeholder {
            color: #b0b3b8 !important;
            opacity: 1;
        }
        .theme-dark .table {
            color: #e5e7eb;
            background: #232b3e;
        }
        .theme-dark .table th {
            background: #232b3e;
            color: #fff;
            border-color: #444c5e;
        }
        .theme-dark .table td {
            background: #232b3e;
            color: #e5e7eb;
            border-color: #444c5e;
        }
        .theme-dark .btn-primary {
            background: #0d6efd;
            border-color: #0d6efd;
            color: #fff;
            transition: background 0.2s, border 0.2s;
        }
        .theme-dark .btn-primary:hover, .theme-dark .btn-primary:focus {
            background: #2563eb;
            border-color: #2563eb;
        }
        .theme-dark .btn-secondary {
            background: #444c5e;
            border-color: #444c5e;
            color: #fff;
            transition: background 0.2s, border 0.2s;
        }
        .theme-dark .btn-secondary:hover, .theme-dark .btn-secondary:focus {
            background: #232b3e;
            border-color: #232b3e;
        }
        .theme-dark .bg-light {
            background: #232b3e !important;
        }
        .theme-dark .bg-white {
            background: #181a1b !important;
        }
        .theme-dark .dropdown-menu {
            background: #232b3e !important;
        }
        .theme-dark .notification-item {
            background: #232b3e !important;
            color: #e5e7eb !important;
        }
        .theme-dark .notification-item.unread {
            background: #1a2032 !important;
        }
        .theme-dark .sidebar-header {
            background: #181a1b !important;
        }
        .theme-dark .user-dropdown-menu {
            background: #232b3e !important;
        }
        .theme-dark .notification-dropdown-menu {
            background: #232b3e !important;
        }
        .theme-dark a, .theme-dark .btn-link {
            color: #60a5fa !important;
            transition: color 0.2s;
        }
        .theme-dark a:hover, .theme-dark .btn-link:hover {
            color: #93c5fd !important;
        }
        .theme-dark .table-striped > tbody > tr:nth-of-type(odd) {
            background-color: #20232a !important;
        }
        .theme-dark .table-hover > tbody > tr:hover {
            background-color: #1a2032 !important;
        }
        .theme-dark .alert {
            background: #232b3e;
            color: #fff;
            border-color: #444c5e;
        }
        .theme-dark .alert-success {
            background: #1e2e1e;
            color: #b6fcb6;
            border-color: #2e7d32;
        }
        .theme-dark .alert-danger, .theme-dark .alert-error {
            background: #2e1e1e;
            color: #fcb6b6;
            border-color: #7d2e32;
        }
        .theme-dark .badge {
            background: #444c5e;
            color: #fff;
        }
        .theme-dark .pagination .page-link {
            background: #232b3e;
            color: #e5e7eb;
            border-color: #444c5e;
        }
        .theme-dark .pagination .page-link.active, .theme-dark .pagination .active > .page-link {
            background: #0d6efd;
            color: #fff;
            border-color: #0d6efd;
        }
        .theme-dark .modal-content {
            background: #232b3e;
            color: #e5e7eb;
            border-color: #444c5e;
        }
        .theme-dark .modal-header, .theme-dark .modal-footer {
            background: #232b3e;
            color: #e5e7eb;
        }
        .btn, .sidebar-menu a, .card, .notification-item, .user-dropdown-toggle, .notification-dropdown-menu, .user-dropdown-menu {
            transition: background 0.2s, color 0.2s, box-shadow 0.2s;
        }
        .btn:active, .sidebar-menu a:active, .card:active {
            transform: scale(0.98);
        }
        .card:hover {
            box-shadow: 0 8px 32px rgba(13,110,253,0.10);
        }
        .notification-dropdown .notification-badge {
            animation: notification-bounce 0.8s infinite alternate;
            top: 2px;
            right: 2px;
        }
        @keyframes notification-bounce {
            from { transform: translateY(0); }
            to { transform: translateY(-4px); }
        }
        .notification-dropdown-menu {
            max-height: 400px;
            overflow-y: auto;
        }
        .notification-item.unread {
            background: #f0f7ff;
            font-weight: 500;
            border-left: 4px solid #0d6efd;
        }
        .notification-item.read {
            opacity: 0.7;
        }
        .notification-item:hover {
            background: #e9ecef;
        }
        .theme-dark .notification-item.unread {
            background: #1a2032 !important;
            border-left: 4px solid #60a5fa;
        }
        .theme-dark .notification-item.read {
            opacity: 0.7;
        }
        .theme-dark .notification-item:hover {
            background: #232b3e !important;
        }
        /* Sticky table header */
        .table thead th {
            position: sticky;
            top: 0;
            background: #fff;
            z-index: 2;
        }
        .theme-dark .table thead th {
            background: #232b3e;
        }
        /* Hosszú szövegek vágása */
        .truncate {
            max-width: 180px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
</head>
<body>
    @php
        $hideSidebar = in_array(Route::currentRouteName(), ['login', 'register']);
        $user = Auth::user();
    @endphp
    <!-- TOAST üzenetek -->
    <div aria-live="polite" aria-atomic="true" class="position-fixed top-0 end-0 p-3" style="z-index: 2000; min-width: 320px;">
        @foreach (['success', 'error', 'warning', 'info', 'status'] as $msg)
            @if(session($msg))
                <div class="toast align-items-center text-bg-{{ $msg == 'error' ? 'danger' : ($msg == 'status' ? 'success' : $msg) }} border-0 mb-2 show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="4000">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session($msg) }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Bezárás"></button>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    @if(!$hideSidebar)
    <div class="sidebar">
        <div class="sidebar-header">
            <i class="bi bi-gear-fill"></i> CRM RENDSZER
        </div>
        <div class="sidebar-user">
            <img src="{{ $user && $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'User') . '&background=0d6efd&color=fff' }}" alt="Profilkép">
            <div class="user-name">{{ $user->name ?? '' }}</div>
        </div>
        <div class="sidebar-menu">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"><i class="bi bi-house"></i> Kezdőlap</a>
            <a href="{{ route('clients.index') }}" class="{{ request()->routeIs('clients.*') ? 'active' : '' }}"><i class="bi bi-people"></i> Ügyfelek</a>
            <a href="{{ route('projects.index') }}" class="{{ request()->routeIs('projects.*') ? 'active' : '' }}"><i class="bi bi-folder"></i> Projektjeim</a>
            <a href="{{ route('tasks.index') }}" class="{{ request()->routeIs('tasks.*') ? 'active' : '' }}"><i class="bi bi-tag"></i> Feladataim</a>
            <a href="{{ route('contacts.index') }}" class="{{ request()->routeIs('contacts.*') ? 'active' : '' }}"><i class="bi bi-person-lines-fill"></i> Kapcsolattartók</a>
            <a href="{{ route('groups.index') }}" class="{{ request()->routeIs('groups.*') ? 'active' : '' }}"><i class="bi bi-collection"></i> Csoportok</a>
            <a href="{{ route('campaigns.index') }}" class="{{ request()->routeIs('campaigns.*') ? 'active' : '' }}"><i class="bi bi-envelope"></i> Kampányok</a>
            <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}"><i class="bi bi-person-badge"></i> Alkalmazottak</a>
            <a href="{{ route('roles.index') }}" class="{{ request()->routeIs('roles.*') ? 'active' : '' }}"><i class="bi bi-shield-lock"></i> Jogosultságok</a>
            <a href="{{ route('currencies.index') }}" class="{{ request()->routeIs('currencies.*') ? 'active' : '' }}"><i class="bi bi-currency-exchange"></i> Valuták</a>
            <a href="{{ route('client-contacts.index') }}" class="{{ request()->routeIs('client-contacts.*') ? 'active' : '' }}"><i class="bi bi-person-lines-fill"></i> Ügyfél-Kapcsolattartók</a>
        </div>
    </div>
    @endif
    <div class="main-content" @if($hideSidebar) style="margin-left:0" @endif>
        @if(!$hideSidebar)
        <div class="topbar">
            <div class="d-flex align-items-center">
                <button id="themeToggle" class="btn btn-link me-3" title="Téma váltás">
                    <i class="bi bi-moon" id="themeIcon"></i>
                </button>
                <div class="notification-dropdown me-3" id="notificationDropdown">
                    <button class="btn btn-link position-relative" onclick="document.getElementById('notificationDropdown').classList.toggle('open')">
                        <i class="bi bi-bell fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-badge" style="display: none;">
                            0
                        </span>
                    </button>
                    <div class="notification-dropdown-menu">
                        <div class="notification-header d-flex justify-content-between align-items-center p-3 border-bottom">
                            <h6 class="mb-0">Értesítések</h6>
                            <a href="{{ route('notifications.index') }}" class="text-decoration-none">Összes</a>
                        </div>
                        <div class="notification-body" style="max-height: 300px; overflow-y: auto;">
                            <div class="notification-list">
                                <!-- Notifications will be loaded here via AJAX -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="user-dropdown" id="userDropdown">
                    <button class="user-dropdown-toggle" onclick="document.getElementById('userDropdown').classList.toggle('open')">
                        <img src="{{ $user && $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'User') . '&background=0d6efd&color=fff' }}" alt="Profilkép">
                        <span>{{ $user->name ?? '' }}</span>
                        <i class="bi bi-caret-down-fill"></i>
                    </button>
                    <div class="user-dropdown-menu">
                        <a href="{{ route('users.edit', auth()->user()) }}"><i class="bi bi-person-circle"></i> Saját profil</a>
                        <a href="{{ route('users.password') }}"><i class="bi bi-key"></i> Jelszó módosítás</a>
                        <a href="{{ route('users.settings') }}"><i class="bi bi-gear"></i> Beállítások</a>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right"></i> Kijelentkezés
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <main class="p-4">
            @yield('content')
        </main>
    </div>
    <script>
        document.addEventListener('click', function(e) {
            var dropdown = document.getElementById('userDropdown');
            if (dropdown && !dropdown.contains(e.target)) {
                dropdown.classList.remove('open');
            }
        });
    </script>
    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Load notifications
        loadNotifications();
        
        // Update notification count every minute
        setInterval(updateNotificationCount, 60000);
    });

    function loadNotifications() {
        fetch('/notifications/latest')
            .then(response => response.json())
            .then(data => {
                const container = document.querySelector('.notification-list');
                if (data.notifications.length === 0) {
                    container.innerHTML = '<div class="p-3 text-center text-muted">Nincsenek új értesítések</div>';
                    return;
                }
                // Legújabb legfelül
                const sorted = data.notifications.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                container.innerHTML = sorted.map(notification => `
                    <div class="notification-item ${notification.is_read ? 'read' : 'unread'}"
                         onclick="markAsRead(${notification.id})">
                        <div class="notification-title">${notification.title}</div>
                        <div class="notification-message">${notification.message}</div>
                        <div class="notification-time">${notification.created_at}</div>
                    </div>
                `).join('');
            });
    }

    function updateNotificationCount() {
        fetch('/notifications/unread-count')
            .then(response => response.json())
            .then(data => {
                const badge = document.querySelector('.notification-badge');
                if (badge) {
                    badge.textContent = data.count;
                    badge.style.display = data.count > 0 ? 'block' : 'none';
                    badge.classList.toggle('animate', data.count > 0);
                }
            });
    }

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
            if (data.success) {
                loadNotifications();
                updateNotificationCount();
            }
        });
    }
    </script>
    @endpush
    <script>
    // Téma váltás kezelése
    function setTheme(theme) {
        document.body.classList.remove('theme-light', 'theme-dark');
        document.body.classList.add('theme-' + theme);
        localStorage.setItem('theme', theme);
        // Ha be van jelentkezve, AJAX-szel elmentjük a szerverre is
        @if(Auth::check())
        fetch('/profile/theme', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ theme })
        });
        @endif
        document.getElementById('themeIcon').className = theme === 'dark' ? 'bi bi-sun' : 'bi bi-moon';
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Alapértelmezett téma beállítása betöltéskor
        let theme = localStorage.getItem('theme');
        @if(Auth::check())
            theme = theme || '{{ $user->theme ?? 'light' }}';
        @endif
        setTheme(theme || 'light');
        document.getElementById('themeToggle').addEventListener('click', function() {
            const current = document.body.classList.contains('theme-dark') ? 'dark' : 'light';
            setTheme(current === 'dark' ? 'light' : 'dark');
        });
    });
    </script>
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toastElList = [].slice.call(document.querySelectorAll('.toast'));
            toastElList.forEach(function(toastEl) {
                var toast = new bootstrap.Toast(toastEl);
                toast.show();
            });
        });
    </script>
</body>
</html> 