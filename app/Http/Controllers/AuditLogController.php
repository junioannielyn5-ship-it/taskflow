<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        // Pansamantalang test data para makita ang Timeline design
        if (AuditLog::count() === 0) {
            $userId = Auth::id();
            $ip = $request->ip();

            AuditLog::create([
                'user_id'    => $userId,
                'action'     => 'Created',
                'model_type' => \App\Modules\Tasks\Models\Task::class,
                'model_id'   => 101,
                'model_label'=> 'P-011-LAWRENCE SOLEE-0017',
                'old_values' => null,
                'new_values' => ['title' => 'New Sales Task', 'status' => 'pending', 'priority' => 'medium'],
                'ip_address' => $ip,
            ]);

            AuditLog::create([
                'user_id'    => $userId,
                'action'     => 'Updated',
                'model_type' => \App\Modules\Tasks\Models\Task::class,
                'model_id'   => 101,
                'model_label'=> 'P-011-LAWRENCE SOLEE-0017',
                'old_values' => ['status' => 'pending'],
                'new_values' => ['status' => 'in_progress'],
                'ip_address' => $ip,
            ]);

            AuditLog::create([
                'user_id'    => $userId,
                'action'     => 'Updated',
                'model_type' => \App\Modules\Tasks\Models\Task::class,
                'model_id'   => 101,
                'model_label'=> 'P-011-LAWRENCE SOLEE-0017',
                'old_values' => ['priority' => 'medium'],
                'new_values' => ['priority' => 'urgent'],
                'ip_address' => $ip,
            ]);

            AuditLog::create([
                'user_id'    => $userId,
                'action'     => 'Created',
                'model_type' => \App\Modules\Projects\Models\Project::class,
                'model_id'   => 5,
                'model_label'=> 'Movaflex Website Redesign',
                'old_values' => null,
                'new_values' => ['name' => 'Movaflex Website Redesign', 'status' => 'active'],
                'ip_address' => $ip,
            ]);

            AuditLog::create([
                'user_id'    => $userId,
                'action'     => 'Deleted',
                'model_type' => \App\Modules\Tasks\Models\Task::class,
                'model_id'   => 99,
                'model_label'=> 'TSK-00099',
                'old_values' => ['title' => 'Old Draft Task', 'status' => 'pending'],
                'new_values' => null,
                'ip_address' => $ip,
            ]);
        }

        $query = AuditLog::with('user:id,name')
            ->orderByDesc('created_at');

        // Filters
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('model_type')) {
            $modelMap = [
                'task'    => \App\Modules\Tasks\Models\Task::class,
                'project' => \App\Modules\Projects\Models\Project::class,
            ];
            $query->where('model_type', $modelMap[$request->model_type] ?? $request->model_type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('model_label', 'like', "%{$search}%")
                  ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        $auditLogs = $query->paginate(10)->withQueryString();

        // Unique users for filter dropdown
        $users = \App\Modules\Identity\Models\User::orderBy('name')
            ->select('id', 'name')
            ->get();

        return view('audit-logs.index', compact('auditLogs', 'users'));
    }
}
