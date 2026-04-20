<?php

namespace App\Modules\Attachments\Policies;

use App\Modules\Attachments\Models\TaskAttachment;
use App\Modules\Identity\Models\User;

class TaskAttachmentPolicy
{
    public function download(User $user, TaskAttachment $attachment): bool
    {
        if ($user->isAdmin() || $user->isPM() || $user->isLead()) {
            return true;
        }

        return $user->projects()->where('projects.id', $attachment->task->project_id)->exists();
    }

    public function delete(User $user, TaskAttachment $attachment): bool
    {
        return $user->id === $attachment->user_id || $user->projects()->where('projects.id', $attachment->task->project_id)->wherePivot('role', 'admin')->exists();
    }
}
