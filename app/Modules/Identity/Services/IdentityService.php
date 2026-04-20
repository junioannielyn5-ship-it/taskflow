<?php

namespace App\Modules\Identity\Services;

use App\Modules\Identity\Models\User;

class IdentityService
{
    /**
     * Check if a user has a specific role.
     */
    public function hasRole(User $user, string $role): bool
    {
        return $user->hasRole($role);
    }

    /**
     * Check if a user has any of the given roles.
     */
    public function hasAnyRole(User $user, array $roles): bool
    {
        return $user->hasAnyRole($roles);
    }

    /**
     * Check if a user is an admin.
     */
    public function isAdmin(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Check if a user is a project manager.
     */
    public function isPM(User $user): bool
    {
        return $user->isPM();
    }

    /**
     * Check if a user is a team lead.
     */
    public function isLead(User $user): bool
    {
        return $user->isLead();
    }

    /**
     * Check if a user is a member.
     */
    public function isMember(User $user): bool
    {
        return $user->isMember();
    }

    /**
     * Get authenticated user.
     */
    public function getAuthenticatedUser(): ?User
    {
        return auth()->user();
    }

    /**
     * Check if user is authenticated.
     */
    public function isAuthenticated(): bool
    {
        return auth()->check();
    }
}
