<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Unauthorized.');
        }

        /** @var \App\Modules\Identity\Models\User $user */

        $allowed = $user->hasAnyRole($roles)
            || $user->roles()->whereIn('name', $roles)->exists();

        if (!$allowed) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
