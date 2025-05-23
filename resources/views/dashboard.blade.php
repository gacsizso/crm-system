@extends('layouts.app')

@section('content')
<style>
    .dashboard-card {
        position: relative;
        overflow: hidden;
        border-radius: 16px;
        min-height: 220px;
        color: #fff;
        box-shadow: 0 2px 16px rgba(0,0,0,0.08);
        background-size: cover;
        background-position: center;
        transition: transform 0.2s;
    }
    .dashboard-card:hover {
        transform: translateY(-4px) scale(1.03);
        box-shadow: 0 6px 24px rgba(0,0,0,0.15);
    }
    .dashboard-card .overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.45);
        z-index: 1;
    }
    .dashboard-card .content {
        position: relative;
        z-index: 2;
        padding: 32px 24px 24px 24px;
        text-align: center;
    }
    .dashboard-card .icon {
        font-size: 2.5rem;
        margin-bottom: 12px;
        opacity: 0.95;
    }
    .dashboard-card .count {
        font-size: 1.1rem;
        margin-bottom: 8px;
        opacity: 0.95;
    }
    .dashboard-card .btn {
        margin-top: 10px;
    }
</style>
<div class="container-fluid">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="dashboard-card" style="background-image:url('https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=600&q=80');">
                <div class="overlay"></div>
                <div class="content">
                    <div class="icon"><i class="bi bi-tag"></i></div>
                    <h5>Feladataim</h5>
                    <div class="count">Összesen {{ $myTasks ?? 0 }} darab Feladatom van</div>
                    <a href="{{ route('tasks.index', ['mine' => 1]) }}" class="btn btn-primary">Tovább</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-card" style="background-image:url('https://images.unsplash.com/photo-1461749280684-dccba630e2f6?auto=format&fit=crop&w=600&q=80');">
                <div class="overlay"></div>
                <div class="content">
                    <div class="icon"><i class="bi bi-file-earmark-text"></i></div>
                    <h5>Projektjeim (árajánlat)</h5>
                    <div class="count">Összesen {{ $myQuoteProjects ?? 0 }} darab Projektem van árajánlat fázisban</div>
                    <a href="{{ route('projects.index', ['status' => 'árajánlat']) }}" class="btn btn-primary">Tovább</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-card" style="background-image:url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=600&q=80');">
                <div class="overlay"></div>
                <div class="content">
                    <div class="icon"><i class="bi bi-cart"></i></div>
                    <h5>Projektjeim (értékesítés)</h5>
                    <div class="count">Összesen {{ $mySalesProjects ?? 0 }} darab Projektem van értékesítés fázisban</div>
                    <a href="{{ route('projects.index', ['status' => 'értékesítés']) }}" class="btn btn-primary">Tovább</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-card" style="background-image:url('https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=crop&w=600&q=80');">
                <div class="overlay"></div>
                <div class="content">
                    <div class="icon"><i class="bi bi-check2-circle"></i></div>
                    <h5>Sikeres projektjeim</h5>
                    <div class="count">Összesen {{ $mySuccessProjects ?? 0 }} darab Projektem van sikeresen lezárva</div>
                    <a href="{{ route('projects.index', ['status' => 'sikeres']) }}" class="btn btn-primary">Tovább</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-card" style="background-image:url('https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=600&q=80');">
                <div class="overlay"></div>
                <div class="content">
                    <div class="icon"><i class="bi bi-people"></i></div>
                    <h5>Ügyfelek</h5>
                    <div class="count">Összesen {{ $clientsCount ?? 0 }} ügyfél van a cég adatbázisában</div>
                    <a href="{{ route('clients.index') }}" class="btn btn-primary">Tovább</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-card" style="background-image:url('https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?auto=format&fit=crop&w=600&q=80');">
                <div class="overlay"></div>
                <div class="content">
                    <div class="icon"><i class="bi bi-person-badge"></i></div>
                    <h5>Munkatársak</h5>
                    <div class="count">Összesen {{ $usersCount ?? 0 }} munkatárs dolgozik a cégnél</div>
                    <a href="{{ route('users.index') }}" class="btn btn-primary">Tovább</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection 