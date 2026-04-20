<?php

namespace App\Modules\Projects\Policies;

use App\Modules\Identity\Models\User;
use App\Modules\Projects\Models\Project;

class ProjectPolicy
{
    /**
     * Determine if the user can view the project.
     */
    public function view(User $user, Project $project): bool
    {
        if ($user->isAdmin() || $user->isPM()) {
            return true;
        }

        // Project creator can view
        if ($user->id === $project->created_by) {
            return true;
        }

        // Global admin can view
        if ($user->isAdmin()) {
            return true;
        }

        // Members can view (even if just added)
        return $project->hasMember($user);
    }

    /**
     * Determine if the user can update the project.
     */
    public function update(User $user, Project $project): bool
    {
        // Project creator can update
        if ($user->id === $project->created_by) {
            return true;
        }

        // Global admin can update
        if ($user->isAdmin()) {
            return true;
        }

        // Project leads can update
        if ($project->isLead($user)) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the user can manage membership of the project.
     */
    public function manageMembership(User $user, Project $project): bool
    {
        return $project->canManageMembership($user);
    }

    /**
     * Determine if the user can delete the project.
     */
    public function delete(User $user, Project $project): bool
    {
        // Only project creator and global admin can delete
        return $user->id === $project->created_by || $user->isAdmin();
    }
}
