<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Modules\Admin\Services\AdminService;
use App\Modules\Identity\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController
{
    public function __construct(private AdminService $adminService) {}

    public function index()
    {
        $this->authorizeAdmin();

        return view('admin.index');
    }

    public function users(Request $request)
    {
        $this->authorizeAdmin();
        $users = $this->adminService->listUsers($request);
        return response()->json($users);
    }

    public function updateRole(Request $request, $id)
    {
        $this->authorizeAdmin();
        $user = User::findOrFail($id);
        $role = $request->input('role');
        $this->adminService->updateUserRole($user, $role);
        return response()->json(['message' => 'User role updated']);
    }

    public function deactivate($id)
    {
        $this->authorizeAdmin();
        $user = User::findOrFail($id);
        $this->adminService->deactivateUser($user);
        return response()->json(['message' => 'User deactivated']);
    }

    public function stats()
    {
        $this->authorizeAdmin();
        $stats = $this->adminService->getSystemStats();
        return response()->json(['data' => $stats]);
    }

    public function createUser()
    {
        $this->authorizeAdmin();

        return view('users.create');
    }

    public function storeUser(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,lead,project_manager,manager,member,pre-sale,sales,technical,admin_support',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.create')->with('success', 'User account successfully created!');
    }

    private function authorizeAdmin()
    {
        /** @var \App\Modules\Identity\Models\User|null $user */
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            abort(403, 'Forbidden');
        }
    }
}
