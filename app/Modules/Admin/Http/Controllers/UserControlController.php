<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Modules\Admin\Services\AdminService;
use App\Modules\Identity\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class UserControlController
{
    public function __construct(private AdminService $adminService) {}

    public function forcePasswordReset(Request $request, $id)
    {
        $this->authorizeAdmin();
        $user = User::findOrFail($id);
        $token = Password::broker()->createToken($user);
        $user->force_password_reset = true;
        $user->save();
        $this->adminService->logForcePasswordReset($user, $token);
        // Optionally, send notification/email to user here
        return response()->json(['message' => 'Password reset required for user', 'reset_token' => $token]);
    }

    private function authorizeAdmin()
    {
        $user = auth()->user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Forbidden');
        }
    }
}
