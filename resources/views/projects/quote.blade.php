<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Árajánlat - {{ $project->name }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; background: #fff; color: #222; }
        .header { text-align: center; margin-bottom: 40px; }
        .header-title { font-size: 2.2em; font-weight: bold; letter-spacing: 2px; color: #2d3e50; margin-bottom: 0; }
        .section { margin-bottom: 28px; }
        .label { font-weight: bold; color: #3a4a5d; display: inline-block; min-width: 160px; }
        .value { color: #222; }
        .table { width: 100%; border-collapse: collapse; margin-top: 12px; margin-bottom: 12px; }
        .table th { background: #f3f6fa; color: #2d3e50; font-weight: bold; border: 1px solid #e0e6ed; padding: 8px; }
        .table td { border: 1px solid #e0e6ed; padding: 8px; }
        .footer { margin-top: 60px; text-align: right; color: #888; font-size: 0.95em; border-top: 1px solid #e0e6ed; padding-top: 16px; }
        .info-list { margin: 0; padding: 0; list-style: none; }
        .info-list li { margin-bottom: 6px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-title">Árajánlat</div>
    </div>
    <div class="section">
        <ul class="info-list">
            <li><span class="label">Projekt neve:</span> <span class="value">{{ $project->name }}</span></li>
            <li><span class="label">Ügyfél:</span> <span class="value">{{ $project->clients->pluck('name')->join(', ') }}</span></li>
            <li><span class="label">Kapcsolattartó:</span> <span class="value">{{ $project->contact->name ?? '-' }}</span></li>
            <li><span class="label">Kapcsolattartó e-mail:</span> <span class="value">{{ $project->contact->email ?? '-' }}</span></li>
            <li><span class="label">Projektmenedzser:</span> <span class="value">{{ $project->manager->name ?? '-' }}</span></li>
            <li><span class="label">Projektmenedzser e-mail:</span> <span class="value">{{ $project->manager->email ?? '-' }}</span></li>
        </ul>
    </div>
    <div class="section">
        <span class="label">Projekt leírása:</span><br>
        <div class="value" style="margin-left: 10px; margin-top: 4px;">{{ $project->description }}</div>
    </div>
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
                <td>{{ number_format($project->hourly_rate * $project->hours, 2) }} {{ $project->currency }}</td>
            </tr>
        </table>
    </div>
    @if($project->note)
    <div class="section">
        <span class="label">Megjegyzés:</span><br>
        <div class="value" style="margin-left: 10px; margin-top: 4px;">{{ $project->note }}</div>
    </div>
    @endif
    <div class="footer">
        <div>{{ now()->format('Y.m.d') }}</div>
        <div>{{ $project->manager->name ?? '' }}</div>
    </div>
</body>
</html> 