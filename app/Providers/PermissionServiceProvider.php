<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Modules\Identity\Models\User;
use App\Modules\Projects\Models\Project;
use App\Modules\Tasks\Models\Task;
use App\Policies\ProjectPolicy;

class PermissionServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::policy(Project::class, ProjectPolicy::class);

        Gate::define('view-own-profile', fn (User $user) => true);
        Gate::define('manage-users', fn (User $user) => $user->isAdmin());
        Gate::define('view-admin-settings', fn (User $user) => $user->isAdmin());

        Gate::define('view-projects', fn (User $user) => true);
        Gate::define('create-project', fn (User $user) => $user->isAdmin() || $user->isPM() || $user->isLead() || $user->hasRole('executive'));
        Gate::define('manage-project-members', fn (User $user) => $user->isAdmin() || $user->isPM() || $user->isLead());

        Gate::define('create-task', fn (User $user) => $user->isAdmin() || $user->isPM() || $user->isLead() || $user->hasRole('executive'));
        Gate::define('edit-task', function (User $user, Task $task): bool {
            if ($user->isAdmin() || $user->isPM()) {
                return true;
            }

            if ($task->created_by === $user->id) {
                return true;
            }

            $project = $task->project ?: Project::withTrashed()->find($task->project_id);

            return (bool) $project?->hasMember($user);
        });

        Gate::define('delete-task', function (User $user, Task $task): bool {
            if ($user->isAdmin() || $user->isPM()) {
                return true;
            }

            $project = $task->project ?: Project::withTrashed()->find($task->project_id);

            return (bool) $project?->isLead($user);
        });

        Gate::define('update-task-status', function (User $user, Task $task): bool {
            if ($user->isAdmin()) {
                return true;
            }

            if ((int) $task->created_by === (int) $user->id) {
                return true;
            }

            if ($user->isLead() || $user->isPM()) {
                return true;
            }

            $isMemberOfTaskProject = DB::table('project_members')
                ->where('project_id', $task->project_id)
                ->where('user_id', $user->id)
                ->exists();

            if ($isMemberOfTaskProject) {
                return true;
            }

            return DB::table('project_members')
                ->where('user_id', $user->id)
                ->exists();
        });
        Gate::define('complete-task', function (User $user, Task $task): bool {
            if ($user->isAdmin() || $user->isPM()) {
                return true;
            }

            if ($user->isLead()) {
                return true;
            }

            $projectRole = DB::table('project_members')
                ->where('project_id', $task->project_id)
                ->where('user_id', $user->id)
                ->value('role');

            return $projectRole === 'lead';
        });
        Gate::define('approve-task-done', fn (User $user, Task $task) => $user->isAdmin() || $user->isPM());
        Gate::define('view-project-reports', fn (User $user) => $user->isAdmin() || $user->isPM() || $user->isLead() || $user->hasRole('executive'));
        Gate::define('view-global-reports', fn (User $user) => $user->isAdmin() || $user->hasRole('executive'));
    }
}
