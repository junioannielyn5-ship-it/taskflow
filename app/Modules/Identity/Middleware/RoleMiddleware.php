<?php

namespace App\Modules\Identity\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $expandedRoles = collect($roles)
            ->map(fn (string $role) => trim($role))
            ->filter()
            ->unique()
            ->values()
            ->all();

        $hasRoleMethod = [$user, 'hasAnyRole'];
        $hasRole = is_callable($hasRoleMethod)
            ? (bool) call_user_func($hasRoleMethod, $expandedRoles)
            : false;

        if (!$hasRole) {
            $hasRole = DB::table('role_user')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('role_user.user_id', $user->id)
                ->whereIn('roles.name', $expandedRoles)
                ->exists();
        }

        if (!$hasRole) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden'], 403);
            }

            abort(403, 'Forbidden');
        }

        return $next($request);
    }
}
