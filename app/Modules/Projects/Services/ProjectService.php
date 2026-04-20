<?php

namespace App\Modules\Projects\Services;

use App\Modules\Identity\Models\User;
use App\Modules\Projects\Models\Project;
use App\Modules\Projects\Models\ProjectMember;

class ProjectService
{
        /**
         * Get all projects for a given user.
         *
         * @param int $userId
         * @return \Illuminate\Support\Collection
         */
        public function getProjectsForUser($userId)
        {
            // Assumes ProjectMember has project_id and user_id columns
            $projectIds = ProjectMember::where('user_id', $userId)->pluck('project_id');
            return Project::whereIn('id', $projectIds)
                ->orWhere('created_by', $userId)
                ->get();
        }
    /**
     * Check if a user is a member of a project.
     */
    public function isMember(int $projectId, int $userId): bool
    {
        $isCreator = Project::where('id', $projectId)
            ->where('created_by', $userId)
            ->exists();

        if ($isCreator) {
            return true;
        }

        return ProjectMember::where('project_id', $projectId)
            ->where('user_id', $userId)
            ->exists();
    }

    /**
     * Check if a user is a member of a project (with model).
     */
    public function isMemberModel(Project $project, User $user): bool
    {
        return $project->hasMember($user);
    }

    /**
     * Check if a user is a lead in a project.
     */
    public function isLead(int $projectId, int $userId): bool
    {
        $isCreator = Project::where('id', $projectId)
            ->where('created_by', $userId)
            ->exists();

        if ($isCreator) {
            return true;
        }

        return ProjectMember::where('project_id', $projectId)
            ->where('user_id', $userId)
            ->where('role', 'lead')
            ->exists();
    }

    /**
     * Get the role of a user in a project.
     */
    public function getUserRole(int $projectId, int $userId): ?string
    {
        return ProjectMember::where('project_id', $projectId)
            ->where('user_id', $userId)
            ->value('role');
    }

    /**
     * Get all projects a user is a member of.
     */
    public function getUserProjects(int $userId)
    {
        return ProjectMember::join('projects', 'project_members.project_id', '=', 'projects.id')
            ->where('project_members.user_id', $userId)
            ->select('projects.*', 'project_members.role as member_role')
            ->get();
    }

    /**
     * Add a user to a project.
     */
    public function addMember(int $projectId, int $userId, string $role = 'member'): ProjectMember
    {
        return ProjectMember::updateOrCreate(
            ['project_id' => $projectId, 'user_id' => $userId],
            ['role' => $role]
        );
    }

    /**
     * Remove a user from a project.
     */
    public function removeMember(int $projectId, int $userId): bool
    {
        return ProjectMember::where('project_id', $projectId)
            ->where('user_id', $userId)
            ->delete() > 0;
    }

    /**
     * Update a user's role in a project.
     */
    public function updateMemberRole(int $projectId, int $userId, string $role): ProjectMember
    {
        $member = ProjectMember::query()
            ->where('project_id', $projectId)
            ->where('user_id', $userId)
            ->firstOrFail();

        if (!$member instanceof ProjectMember) {
            throw new \RuntimeException('Invalid project member record.');
        }

        $member->update(['role' => $role]);

        return $member->refresh();
    }

    /**
     * Check if user can manage membership in a project.
     */
    public function canManageMembership(int $projectId, int $userId): bool
    {
        /** @var Project|null $project */
        $project = Project::find($projectId);

        if (!$project) {
            return false;
        }

        /** @var User|null $user */
        $user = User::find($userId);

        if (!$user) {
            return false;
        }

        return $project->canManageMembership($user);
    }

    /**
     * Get all members of a project.
     */
    public function getProjectMembers(int $projectId)
    {
        return ProjectMember::where('project_id', $projectId)
            ->with('user')
            ->get();
    }
}
