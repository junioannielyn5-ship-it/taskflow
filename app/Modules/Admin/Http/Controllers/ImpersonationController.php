<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Modules\Identity\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ImpersonationController
{
    public function start(Request $request, $id)
    {
        $this->authorizeAdmin();
        $user = User::findOrFail($id);
        session(['impersonate' => $user->id]);
        return response()->json(['message' => 'Impersonation started', 'user_id' => $user->id]);
    }

    public function stop(Request $request)
    {
        $this->authorizeAdmin();
        session()->forget('impersonate');
        return response()->json(['message' => 'Impersonation stopped']);
    }

    private function authorizeAdmin()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Forbidden');
        }
    }
}
