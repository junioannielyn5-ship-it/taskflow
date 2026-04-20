<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Identity\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserAdminController extends Controller
{
    public function index()
    {
        Gate::authorize('admin-only');
        $users = User::with('roles')->get();
        return response()->json($users);
    }

    public function updateRole(Request $request, User $user)
    {
        Gate::authorize('admin-only');
        $validated = $request->validate([
            'role' => 'required|string|in:admin,manager,lead,member',
        ]);
        $user->syncRoles([$validated['role']]);
        return response()->json($user->fresh('roles'));
    }
}
