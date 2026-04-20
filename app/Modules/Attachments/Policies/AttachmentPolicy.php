<?php

namespace App\Modules\Attachments\Policies;

use App\Modules\Attachments\Models\TaskAttachment;
use App\Modules\Identity\Models\User;

class AttachmentPolicy
{
    /**
     * Determine if the user can view the attachment.
     */
    public function view(User $user, TaskAttachment $attachment): bool
    {
        // Allow if user is admin
        if ($user->role === 'admin') {
            return true;
        }

        // Allow if user is the creator
        if ($attachment->user_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the user can delete the attachment.
     */
    public function delete(User $user, TaskAttachment $attachment): bool
    {
        // Allow if user is admin
        if ($user->role === 'admin') {
            return true;
        }

        // Allow if user is the creator
        if ($attachment->user_id === $user->id) {
            return true;
        }

        return false;
    }
}
