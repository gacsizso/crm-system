<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User permissions
            'view users',
            'create users',
            'edit users',
            'delete users',
            
            // Client permissions
            'view clients',
            'create clients',
            'edit clients',
            'delete clients',
            
            // Project permissions
            'view projects',
            'create projects',
            'edit projects',
            'delete projects',
            
            // Task permissions
            'view tasks',
            'create tasks',
            'edit tasks',
            'delete tasks',
            
            // Contact permissions
            'view contacts',
            'create contacts',
            'edit contacts',
            'delete contacts',
            
            // Group permissions
            'view groups',
            'create groups',
            'edit groups',
            'delete groups',
            
            // Campaign permissions
            'view campaigns',
            'create campaigns',
            'edit campaigns',
            'delete campaigns',
            
            // Currency permissions
            'view currencies',
            'create currencies',
            'edit currencies',
            'delete currencies',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $roles = [
            'admin' => $permissions,
            'manager' => [
                'view users', 'create users', 'edit users',
                'view clients', 'create clients', 'edit clients', 'delete clients',
                'view projects', 'create projects', 'edit projects', 'delete projects',
                'view tasks', 'create tasks', 'edit tasks', 'delete tasks',
                'view contacts', 'create contacts', 'edit contacts', 'delete contacts',
                'view groups', 'create groups', 'edit groups', 'delete groups',
                'view campaigns', 'create campaigns', 'edit campaigns', 'delete campaigns',
                'view currencies', 'create currencies', 'edit currencies', 'delete currencies',
            ],
            'employee' => [
                'view clients',
                'view projects', 'create projects', 'edit projects',
                'view tasks', 'create tasks', 'edit tasks',
                'view contacts', 'create contacts', 'edit contacts',
                'view groups',
                'view campaigns',
                'view currencies',
            ],
            'staff' => [
                'view clients',
                'view projects',
                'view tasks',
                'view contacts',
                'view groups',
                'view campaigns',
                'view currencies',
            ],
            'user' => [
                'view clients',
                'view projects',
                'view tasks',
            ],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::create(['name' => $roleName, 'guard_name' => 'web']);
            $role->givePermissionTo($rolePermissions);
        }
    }
} 