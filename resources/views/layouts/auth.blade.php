<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bejelentkezés') - CRM rendszer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        html, body { height: 100%; margin: 0; padding: 0; }
        body { min-height: 100vh; background: #181a1b; }
        .auth-container {
            display: flex;
            min-height: 100vh;
        }
        .auth-image {
            flex: 1 1 0;
            background: url('https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=800&q=80') center center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            min-width: 0;
        }
        .auth-image .overlay {
            background: rgba(24,26,27,0.7);
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0; left: 0;
        }
        .auth-image-content {
            position: relative;
            z-index: 2;
            padding: 48px;
            text-align: left;
        }
        .auth-form-side {
            flex: 1 1 0;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 0;
        }
        .auth-form-side .auth-form {
            width: 100%;
            max-width: 400px;
            padding: 48px 32px;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 8px 32px rgba(0,0,0,0.10);
        }
        .theme-dark .auth-form-side, .theme-dark .auth-form {
            background: #232b3e !important;
            color: #e5e7eb !important;
        }
        .theme-dark .form-control, .theme-dark .form-label, .theme-dark label {
            background: #232b3e !important;
            color: #e5e7eb !important;
        }
        .theme-dark .form-control::placeholder {
            color: #b0b3b8 !important;
        }
        .theme-dark .btn-primary {
            background: #0d6efd;
            border-color: #0d6efd;
        }
        @media (max-width: 900px) {
            .auth-container { flex-direction: column; }
            .auth-image, .auth-form-side { flex: none; width: 100%; min-height: 40vh; }
            .auth-form-side { min-height: 60vh; }
        }
    </style>
</head>
<body class="@if(session('theme', 'light') === 'dark') theme-dark @endif">
    <div class="auth-container">
        <div class="auth-image position-relative">
            <div class="overlay position-absolute"></div>
            <div class="auth-image-content">
                <h1 class="fw-bold mb-3">CRM RENDSZER</h1>
                <p class="fs-5">Üdvözöljük!<br>Jelentkezzen be a rendszer használatához.</p>
            </div>
        </div>
        <div class="auth-form-side">
            <div class="auth-form">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html> 