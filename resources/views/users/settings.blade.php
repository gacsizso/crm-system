@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Beállítások</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('users.settings.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Értesítések</label>
                            <div class="form-check">
                                <input type="checkbox" 
                                       class="form-check-input" 
                                       id="notify_task_assigned" 
                                       name="settings[notify_task_assigned]" 
                                       value="1"
                                       {{ old('settings.notify_task_assigned', $user->settings['notify_task_assigned'] ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="notify_task_assigned">
                                    Értesítés új feladat hozzárendelésekor
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" 
                                       class="form-check-input" 
                                       id="notify_project_updated" 
                                       name="settings[notify_project_updated]" 
                                       value="1"
                                       {{ old('settings.notify_project_updated', $user->settings['notify_project_updated'] ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="notify_project_updated">
                                    Értesítés projekt frissítésekor
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" 
                                       class="form-check-input" 
                                       id="notify_deadline" 
                                       name="settings[notify_deadline]" 
                                       value="1"
                                       {{ old('settings.notify_deadline', $user->settings['notify_deadline'] ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="notify_deadline">
                                    Értesítés közelgő határidőről
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email értesítések</label>
                            <div class="form-check">
                                <input type="checkbox" 
                                       class="form-check-input" 
                                       id="email_notifications" 
                                       name="settings[email_notifications]" 
                                       value="1"
                                       {{ old('settings.email_notifications', $user->settings['email_notifications'] ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="email_notifications">
                                    Email értesítések küldése
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Dashboard beállítások</label>
                            <div class="form-check">
                                <input type="checkbox" 
                                       class="form-check-input" 
                                       id="show_tasks_widget" 
                                       name="settings[show_tasks_widget]" 
                                       value="1"
                                       {{ old('settings.show_tasks_widget', $user->settings['show_tasks_widget'] ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="show_tasks_widget">
                                    Feladatok widget megjelenítése
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" 
                                       class="form-check-input" 
                                       id="show_projects_widget" 
                                       name="settings[show_projects_widget]" 
                                       value="1"
                                       {{ old('settings.show_projects_widget', $user->settings['show_projects_widget'] ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="show_projects_widget">
                                    Projektek widget megjelenítése
                                </label>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                Beállítások mentése
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 