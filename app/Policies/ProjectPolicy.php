<?php

namespace App\Policies;

use App\Modules\Identity\Models\User;
use App\Modules\Projects\Models\Project;

class ProjectPolicy
{
    public function view(User $user, Project $project): bool
    {
        if ($user->isAdmin() || $user->isPM()) {
            return true;
        }

        if ($user->id === $project->created_by) {
            return true;
        }

        return $project->hasMember($user);
    }

    public function update(User $user, Project $project): bool
    {
        if ($user->isAdmin() || $user->isPM()) {
            return true;
        }

        return $project->isLead($user);
    }

    public function delete(User $user, Project $project): bool
    {
        if ($user->isAdmin() || $user->isPM()) {
            return true;
        }

        return $project->isLead($user);
    }

    public function manageMembership(User $user, Project $project): bool
    {
        if ($user->isAdmin() || $user->isPM()) {
            return true;
        }

        return $project->isLead($user);
    }
}
