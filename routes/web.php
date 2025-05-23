<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    // Saját profil szerkesztése
    // Route::get('/profile', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
    // Route::put('/profile', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::get('/profile/password', [App\Http\Controllers\UserController::class, 'password'])->name('users.password');
    Route::put('/profile/password', [App\Http\Controllers\UserController::class, 'updatePassword'])->name('users.password.update');
    Route::get('/profile/settings', [App\Http\Controllers\UserController::class, 'settings'])->name('users.settings');
    Route::put('/profile/settings', [App\Http\Controllers\UserController::class, 'updateSettings'])->name('users.settings.update');
    Route::post('/profile/theme', [App\Http\Controllers\UserController::class, 'updateTheme'])->name('users.theme');

    // Notification routes
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/mark-as-read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::post('/notifications/mark-all-as-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');
    Route::get('/notifications/unread-count', [App\Http\Controllers\NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::get('/notifications/latest', [App\Http\Controllers\NotificationController::class, 'getLatest'])->name('notifications.latest');

    // Resource routes
    Route::resource('clients', App\Http\Controllers\ClientController::class);
    Route::resource('contacts', App\Http\Controllers\ContactController::class);
    Route::resource('groups', App\Http\Controllers\GroupController::class);
    Route::resource('projects', App\Http\Controllers\ProjectController::class);
    Route::patch('projects/{project}/status', [App\Http\Controllers\ProjectController::class, 'changeStatus'])->name('projects.status');
    Route::get('projects/{project}/quote', [App\Http\Controllers\ProjectController::class, 'quote'])->name('projects.quote');
    Route::resource('tasks', App\Http\Controllers\TaskController::class);
    Route::post('tasks/{task}/assign', [App\Http\Controllers\TaskController::class, 'assign'])->name('tasks.assign');
    Route::patch('tasks/{task}/status', [App\Http\Controllers\TaskController::class, 'changeStatus'])->name('tasks.changeStatus');
    Route::resource('campaigns', App\Http\Controllers\CampaignController::class);
    Route::get('campaigns/{campaign}/preview', [App\Http\Controllers\CampaignController::class, 'preview'])->name('campaigns.preview');
    Route::post('campaigns/{campaign}/send', [App\Http\Controllers\CampaignController::class, 'send'])->name('campaigns.send');
    Route::resource('currencies', App\Http\Controllers\CurrencyController::class);
    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('client-contacts', App\Http\Controllers\ClientContactController::class);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
