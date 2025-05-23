<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            RoleSeeder::class,
        ]);
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $manager = User::factory()->create([
            'name' => 'Menedzser Felhasználó',
            'email' => 'menedzser@email.com',
            'password' => bcrypt('password'),
            'role' => 'manager',
        ]);
        $manager->assignRole('manager');

        $user = User::factory()->create([
            'name' => 'Normál Felhasználó',
            'email' => 'felhasznalo@email.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        $user->assignRole('user');

        $employee = User::factory()->create([
            'name' => 'Normál Alkalmazott',
            'email' => 'alkalmazott@email.com',
            'password' => bcrypt('password'),
            'role' => 'employee',
        ]);
        $employee->assignRole('employee');

        $staff = User::factory()->create([
            'name' => 'Normál Munkatárs',
            'email' => 'munkatars@email.com',
            'password' => bcrypt('password'),
            'role' => 'staff',
        ]);
        $staff->assignRole('staff');
    }
}
