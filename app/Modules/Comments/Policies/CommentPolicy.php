<?php

namespace App\Modules\Comments\Policies;

use App\Modules\Comments\Models\TaskComment;
use App\Modules\Identity\Models\User;

class CommentPolicy
{
    /**
     * Determine if the user can view a comment.
     */
    public function view(User $user, TaskComment $comment): bool
    {
        // Admin can view any comment
        if ($user->isAdmin()) {
            return true;
        }

        // Users can view comments on tasks they have access to
        // This is handled at the task level, so we allow it here
        return true;
    }

    /**
     * Determine if the user can update a comment.
     */
    public function update(User $user, TaskComment $comment): bool
    {
        // Admin can update any comment
        if ($user->isAdmin()) {
            return true;
        }

        // User can only update their own comments
        return $user->id === $comment->user_id;
    }

    /**
     * Determine if the user can delete a comment.
     */
    public function delete(User $user, TaskComment $comment): bool
    {
        // Admin can delete any comment
        if ($user->isAdmin()) {
            return true;
        }

        // User can only delete their own comments
        return $user->id === $comment->user_id;
    }
}
