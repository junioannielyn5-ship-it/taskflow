<?php

namespace App\Modules\Tasks\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Tasks\Models\Task;
use App\Modules\Workflow\Models\TaskActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TaskActivityController extends Controller
{
    public function index(Request $request, Task $task)
    {
        Gate::authorize('view', $task);

        $activity = TaskActivityLog::where('task_id', $task->id)
            ->with('actor:id,name,email')
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'task_id' => $task->id,
            'activity_count' => $activity->count(),
            'activities' => $activity->map(function (TaskActivityLog $entry) {
                $isSystem = ((int) $entry->actor_id === 0)
                    || is_null($entry->actor)
                    || (($entry->metadata['actor'] ?? null) === 'System')
                    || (strtolower((string) $entry->actor?->name) === 'system');

                return [
                    'id' => $entry->id,
                    'action_type' => $entry->action_type,
                    'description' => $entry->getDescription(),
                    'action_text' => $entry->getDescription(),
                    'old_value' => $entry->old_value,
                    'new_value' => $entry->new_value,
                    'is_system' => $isSystem,
                    'is_automation' => $isSystem,
                    'actor' => [
                        'id' => $entry->actor?->id,
                        'name' => $isSystem ? 'System Bot' : ($entry->actor?->name ?? 'Unknown User'),
                        'avatar' => null,
                        'email' => $entry->actor?->email,
                    ],
                    'actor_name' => $isSystem ? 'System Bot' : ($entry->actor?->name ?? 'Unknown User'),
                    'timestamp' => $entry->created_at?->toIso8601String(),
                    'timestamp_human' => $entry->created_at?->diffForHumans(),
                    'created_at_human' => $entry->created_at?->diffForHumans(),
                    'metadata' => $entry->metadata,
                ];
            })->values(),
        ]);
    }
}
