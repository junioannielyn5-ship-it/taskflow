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

    public function manageUsers()
    {
        $this->authorizeAdmin();
        $users = User::orderBy('name')->get();
        return view('users.index', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $this->authorizeAdmin();
        
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:50',
            'phone_no' => ['nullable', 'string', 'regex:/^09\d{9}$/'],
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,lead,project_manager,manager,member,pre-sale,sales,technical,admin_support',
            'profile_picture' => 'nullable|image|max:2048'
        ]);

        $nameParts = array_filter([$request->first_name, $request->middle_name, $request->last_name, $request->suffix]);
        $fullName = implode(' ', $nameParts);

        $path = null;
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profiles', 'public');
        }

        User::create([
            'name' => $fullName,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'suffix' => $request->suffix,
            'phone_no' => $request->phone_no,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'profile_photo_path' => $path
        ]);

        return redirect()->route('users.index')->with('success', 'User account successfully created!');
    }

    public function updateUser(Request $request, User $user)
    {
        $this->authorizeAdmin();
        
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:50',
            'phone_no' => ['nullable', 'string', 'regex:/^09\d{9}$/'],
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,lead,project_manager,manager,member,pre-sale,sales,technical,admin_support',
            'profile_picture' => 'nullable|image|max:2048'
        ]);

        $nameParts = array_filter([$request->first_name, $request->middle_name, $request->last_name, $request->suffix]);
        $fullName = implode(' ', $nameParts);

        $user->fill([
            'name' => $fullName,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'suffix' => $request->suffix,
            'phone_no' => $request->phone_no,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile_picture')) {
            $user->profile_photo_path = $request->file('profile_picture')->store('profiles', 'public');
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User account successfully updated!');
    }

    public function destroyUser(User $user)
    {
        $this->authorizeAdmin();
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deactivated/deleted successfully!');
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
