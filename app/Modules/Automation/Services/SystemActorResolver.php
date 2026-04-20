<?php

namespace App\Modules\Automation\Services;

use App\Modules\Identity\Models\User;
use Illuminate\Support\Facades\Hash;

class SystemActorResolver
{
    public function resolve(): User
    {
        return User::query()->firstOrCreate(
            ['email' => 'system.automation@local'],
            [
                'name' => 'System',
                'password' => Hash::make('automation-system-user'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
