<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Contact;
use App\Models\Client;
use App\Models\Task;
use App\Models\Group;
use App\Models\Project;
use App\Policies\UserPolicy;
use App\Policies\ContactPolicy;
use App\Policies\ClientPolicy;
use App\Policies\TaskPolicy;
use App\Policies\GroupPolicy;
use App\Policies\ProjectPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
        Contact::class => ContactPolicy::class,
        Client::class => ClientPolicy::class,
        Project::class => ProjectPolicy::class,
        Task::class => TaskPolicy::class,
        Group::class => GroupPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // Implicitly grant "Super Admin" role all permissions
        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });
    }
} 