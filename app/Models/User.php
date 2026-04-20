<?php

namespace App\Models;

/**
 * @deprecated This class has been moved to the Identity module.
 * Use App\Modules\Identity\Models\User instead.
 */
class User extends \App\Modules\Identity\Models\User
{
    // This class exists for backward compatibility only.
    // All functionality has been moved to App\Modules\Identity\Models\User
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    public function hasRole(string $role): bool
    {
        return $this->roles->contains('name', $role);
    }
}
