@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Admin Dashboard') }}</div>

                <div class="card-body">
                    <!-- Statisztikák -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Felhasználók</h5>
                                    <p class="card-text display-4">{{ $stats['users'] }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Ügyfelek</h5>
                                    <p class="card-text display-4">{{ $stats['clients'] }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Projektek</h5>
                                    <p class="card-text display-4">{{ $stats['projects'] }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Feladatok</h5>
                                    <p class="card-text display-4">{{ $stats['tasks'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Projekt státuszok -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Projekt státuszok</div>
                                <div class="card-body">
                                    <div class="progress mb-3">
                                        <div class="progress-bar bg-success" role="progressbar" 
                                             style="width: {{ ($stats['completed_projects'] / max($stats['projects'], 1)) * 100 }}%">
                                            Befejezett ({{ $stats['completed_projects'] }})
                                        </div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" role="progressbar" 
                                             style="width: {{ ($stats['active_projects'] / max($stats['projects'], 1)) * 100 }}%">
                                            Aktív ({{ $stats['active_projects'] }})
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 