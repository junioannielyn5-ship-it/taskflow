<?php

namespace App\Modules\Reporting\Policies;

use App\Modules\Identity\Models\User;

class ReportPolicy
{
    public function viewReports(User $user): bool
    {
        return $user->hasRole('admin')
            || $user->hasRole('project_manager')
            || $user->hasRole('executive')
            || $user->hasRole('lead');
    }
}
