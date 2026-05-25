<?php

namespace App\Modules\Notifications\Http\Controllers;

use App\Modules\Identity\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController
{
    public function history(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $perPage = max(1, min(100, (int) $request->integer('per_page', 20)));
        $notifications = $user->notifications()->latest()->paginate($perPage)->withQueryString();

        return view('notifications.index', [
            'notifications' => $notifications,
        ]);
    }

    public function index(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $perPage = max(1, min(100, (int) $request->integer('per_page', 20)));
        $notifications = $user->notifications()->latest()->paginate($perPage)->withQueryString();

        return response()->json([
            'data' => $notifications->items(),
            'pagination' => [
                'current_page' => $notifications->currentPage(),
                'last_page' => $notifications->lastPage(),
                'per_page' => $notifications->perPage(),
                'total' => $notifications->total(),
            ],
        ]);
    }

    public function markAsRead(Request $request, string $id)
    {
        /** @var User $user */
        $user = Auth::user();
        $notification = $user->notifications()->where('id', $id)->firstOrFail();
        $notification->markAsRead();

        if (!$request->expectsJson()) {
            return back()->with('success', 'Notification marked as read.');
        }

        return response()->json([
            'message' => 'Notification marked as read',
            'unread_count' => $user->unreadNotifications()->count(),
        ]);
    }

    public function markAllAsRead(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();

        if (!$request->expectsJson()) {
            return back()->with('success', 'All notifications marked as read.');
        }

        return response()->json([
            'message' => 'All notifications marked as read',
            'unread_count' => 0,
        ]);
    }
}
