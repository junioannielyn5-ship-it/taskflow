<?php

namespace App\Modules\Admin\Services;

use App\Modules\Identity\Models\User;
use App\Modules\Projects\Models\Project;
use App\Modules\Tasks\Models\Task;
use Illuminate\Support\Facades\DB;
use App\Modules\Admin\QueryFilters\UserFilter;
use Illuminate\Http\Request;
use App\Modules\Admin\Models\AdminAuditLog;
use Illuminate\Support\Facades\Request as RequestFacade;

class AdminService
{
    public function listUsers(Request $request)
    {
        $query = User::query();
        $filter = new UserFilter($request);
        $query = $filter->apply($query);
        return $query->paginate(20);
    }

    public function updateUserRole(User $user, string $role): void
    {
        $admin = auth()->user();
        $oldRole = $user->role;
        $user->role = $role;
        $user->save();
        AdminAuditLog::create([
            'admin_id' => $admin->id,
            'action' => 'update_user_role',
            'details' => ['user_id' => $user->id, 'old_role' => $oldRole, 'new_role' => $role],
            'ip_address' => RequestFacade::ip(),
        ]);
    }

    public function deactivateUser(User $user): void
    {
        $admin = auth()->user();
        $user->active = false;
        $user->save();
        AdminAuditLog::create([
            'admin_id' => $admin->id,
            'action' => 'deactivate_user',
            'details' => ['user_id' => $user->id],
            'ip_address' => RequestFacade::ip(),
        ]);
    }

    public function getSystemStats(): array
    {
        $totalUsers = User::count();
        $totalProjects = Project::count();
        $totalTasks = Task::count();
        $completedTasks = Task::where('status', 'done')->count();
        $completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 2) : 0;
        return [
            'total_users' => $totalUsers,
            'total_projects' => $totalProjects,
            'total_tasks' => $totalTasks,
            'completion_rate' => $completionRate,
        ];
    }

    public function logForcePasswordReset(User $user, string $token): void
    {
        $admin = auth()->user();
        \App\Modules\Admin\Models\AdminAuditLog::create([
            'admin_id' => $admin->id,
            'action' => 'force_password_reset',
            'details' => ['user_id' => $user->id, 'reset_token' => $token],
            'ip_address' => request()->ip(),
        ]);
    }
}
