<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RoleLoginController extends Controller
{
    private const ALLOWED_ROLES = ['admin', 'member', 'lead', 'project_manager', 'manager', 'executive'];

    private const ROLE_ALIASES = [
        'team-lead' => 'lead',
        'team_lead' => 'lead',
        'project-manager' => 'project_manager',
        'project_manager' => 'project_manager',
        'project manager' => 'project_manager',
        'pm' => 'project_manager',
    ];

    public function launcher(): View
    {
        return view('auth.role-login-launcher', [
            'roles' => self::ALLOWED_ROLES,
        ]);
    }

    public function show(string $role): View
    {
        $normalizedRole = $this->normalizeRole($role);

        abort_unless(in_array($normalizedRole, self::ALLOWED_ROLES, true), 404);

        return view('auth.role-login', [
            'role' => $normalizedRole,
            'roleLabel' => $this->labelForRole($normalizedRole),
        ]);
    }

    public function login(Request $request, string $role): RedirectResponse
    {
        $normalizedRole = $this->normalizeRole($role);

        abort_unless(in_array($normalizedRole, self::ALLOWED_ROLES, true), 404);

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ]);

        if (!Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ], (bool) ($credentials['remember'] ?? false))) {
            throw ValidationException::withMessages([
                'email' => 'These credentials do not match our records.',
            ]);
        }

        $request->session()->regenerate();

        $user = $request->user();
        if (!$user || !$this->canAccessRoleLogin($user, $normalizedRole)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => 'These credentials do not match our records for this role.',
            ]);
        }

        return redirect()->intended($this->defaultRouteForRole($normalizedRole));
    }

    private function normalizeRole(string $role): string
    {
        $normalized = str_replace('-', '_', strtolower(trim($role)));

        return self::ROLE_ALIASES[$normalized] ?? $normalized;
    }

    private function labelForRole(string $role): string
    {
        return match ($role) {
            'project_manager' => 'Project Manager',
            'lead' => 'Team Lead',
            default => str($role)->replace('_', ' ')->title()->toString(),
        };
    }

    private function canAccessRoleLogin(object $user, string $role): bool
    {
        return match ($role) {
            'project_manager' => method_exists($user, 'hasAnyRole') && $user->hasAnyRole(['project_manager', 'pm', 'manager']),
            default => method_exists($user, 'hasRole') && $user->hasRole($role),
        };
    }

    private function defaultRouteForRole(string $role): string
    {
        return match ($role) {
            'admin' => route('admin.index'),
            'manager' => route('manager.index'),
            'project_manager' => route('project-manager.index'),
            'executive' => route('executive.index'),
            'lead' => route('lead.index'),
            default => route('tasks.kanban'),
        };
    }
}
