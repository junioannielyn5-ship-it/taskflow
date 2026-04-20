<?php

namespace App\Modules\Notifications\Services;

use App\Modules\Identity\Models\User;

class NotificationService
{
    /**
     * Get unread notifications for a user.
     *
     * @param int $userId
     * @return \Illuminate\Support\Collection
     */
    /**
     * Fetch unread notifications for the dashboard.
     */
    public function getUnread(User $user, int $limit = 5)
    {
        return $user->unreadNotifications()
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Mark a specific notification as read.
     */
    public function markAsRead(int $notificationId)
    {
        return \Illuminate\Notifications\DatabaseNotification::query()
            ->where('id', $notificationId)
            ->update(['read_at' => now()]);
    }

}
