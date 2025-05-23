<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Árajánlat - {{ $project->name }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; background: #fff; color: #222; margin: 0; padding: 0; }
        .header { text-align: center; margin-bottom: 16px; }
        .header-title { font-size: 2.1em; font-weight: bold; color: #0d6efd; margin-bottom: 0; letter-spacing: 1px; }
        .header-date { font-size: 1em; color: #888; margin-top: 2px; }
        .flex-row { display: flex; justify-content: space-between; gap: 24px; margin-bottom: 14px; }
        .box { flex: 1; border: 1px solid #e0e6ed; border-radius: 7px; padding: 12px 16px; background: #f8fafc; min-width: 0; min-height: 110px; display: flex; flex-direction: column; justify-content: center; }
        .box-title { font-weight: bold; color: #0d6efd; margin-bottom: 7px; font-size: 1.05em; text-align: center; }
        .info-list { margin: 0; padding: 0; list-style: none; font-size: 0.99em; }
        .info-list li { margin-bottom: 4px; white-space: nowrap; }
        .label { font-weight: bold; color: #3a4a5d; min-width: 90px; display: inline-block; }
        .value { color: #222; }
        .section { margin-bottom: 13px; }
        .project-title { text-align: center; font-size: 1.13em; font-weight: bold; color: #222; margin-bottom: 7px; }
        .desc, .note-text { margin-left: 6px; margin-top: 2px; font-size: 0.99em; white-space: pre-line; }
        .tasks-list { margin: 0 0 0 18px; padding: 0; font-size: 0.99em; }
        .tasks-list li { margin-bottom: 2px; list-style-type: disc; }
        .table { width: 100%; border-collapse: collapse; margin-top: 8px; margin-bottom: 8px; font-size: 0.99em; }
        .table th { background: #e9f0fa; color: #0d6efd; font-weight: bold; border: 1px solid #b6c6e3; padding: 8px; font-size: 1em; text-align: center; }
        .table td { border: 1px solid #b6c6e3; padding: 8px; font-size: 1em; text-align: center; }
        .table-total { background: #f8fafc; font-weight: bold; color: #0d6efd; font-size: 1.13em; letter-spacing: 1px; }
        .signatures { margin-top: 28px; display: flex; justify-content: flex-end; }
        .sign-box { width: 220px; text-align: center; }
        .sign-label { color: #888; font-size: 0.97em; margin-bottom: 10px; }
        .sign-line { border-bottom: 1.5px dashed #bbb; width: 80%; margin: 0 auto 8px auto; height: 22px; }
        @media print {
            body { margin: 0; }
            .header, .section, .flex-row, .signatures { page-break-inside: avoid; }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-title">Árajánlat</div>
        <div class="header-date">Készült: {{ now()->format('Y.m.d') }}</div>
    </div>
    <div class="flex-row">
        <div class="box">
            <div class="box-title">Címzett</div>
            <ul class="info-list">
                <li><span class="label">Név:</span> <span class="value">{{ $project->clients->pluck('name')->join(', ') }}</span></li>
                <li><span class="label">Kapcsolattartó:</span> <span class="value">{{ $project->contact->name ?? '-' }}</span></li>
                <li><span class="label">E-mail:</span> <span class="value">{{ $project->contact->email ?? '-' }}</span></li>
            </ul>
        </div>
        <div class="box">
            <div class="box-title">Feladó</div>
            <ul class="info-list">
                <li><span class="label">Felhasználó:</span> <span class="value">{{ auth()->user()->name ?? '-' }}</span></li>
                <li><span class="label">E-mail:</span> <span class="value">{{ auth()->user()->email ?? '-' }}</span></li>
                <li><span class="label">Projektmenedzser:</span> <span class="value">{{ $project->manager->name ?? '-' }}</span></li>
                <li><span class="label">Menedzser e-mail:</span> <span class="value">{{ $project->manager->email ?? '-' }}</span></li>
            </ul>
        </div>
    </div>
    <div class="section">
        <div class="project-title">{{ $project->name }}</div>
        <span class="label">Projekt leírása:</span>
        <span class="desc">{{ $project->description }}</span>
    </div>
    @if($project->tasks && $project->tasks->count())
    <div class="section">
        <span class="label">Feladatok:</span>
        <ul class="tasks-list">
            @foreach($project->tasks as $task)
                <li>{{ $task->name }} @if($task->status) ({{ $task->status }}) @endif</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="section">
        <table class="table">
            <tr>
                <th>Határidő</th>
                <th>Munkaórák száma</th>
                <th>Óradíj</th>
                <th>Összesen</th>
            </tr>
            <tr>
                <td>{{ $project->deadline }}</td>
                <td>{{ $project->hours }}</td>
                <td>{{ number_format($project->hourly_rate, 2) }} {{ $project->currency }}</td>
                <td class="table-total">{{ number_format($project->hourly_rate * $project->hours, 2) }} {{ $project->currency }}</td>
            </tr>
        </table>
    </div>
    @if($project->note)
    <div class="section">
        <span class="label">Megjegyzés:</span>
        <span class="note-text">{{ $project->note }}</span>
    </div>
    @endif
    <div class="signatures">
        <div class="sign-box">
            <div class="sign-label">Aláírás</div>
            <div class="sign-line"></div>
            <div>{{ auth()->user()->name ?? '-' }}</div>
        </div>
    </div>
</body>
</html> 