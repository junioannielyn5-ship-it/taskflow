<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['admin', 'member', 'lead', 'project_manager', 'pm', 'executive', 'manager'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Create initial admin account
        $admin = \App\Models\User::firstOrCreate([
            'email' => 'annielynjunio@example.com'
        ], [
            'name' => 'Annielyn Junio',
            'password' => bcrypt('securepassword'),
            'role' => 'admin',
        ]);

        if ($admin->role !== 'admin') {
            $admin->role = 'admin';
            $admin->save();
        }

        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole && !$admin->roles->contains($adminRole->id)) {
            $admin->roles()->attach($adminRole->id);
        }
    }
}
