<?php

namespace App\Modules\Tasks\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Tasks\Models\Task;
use App\Modules\Tasks\Models\TaskTimeLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskTimeLogController extends Controller
{
    public function start(Request $request, Task $task)
    {
        $this->authorize('view', $task);

        $user = $request->user();
        $alreadyRunning = TaskTimeLog::query()
            ->where('task_id', $task->id)
            ->where('user_id', $user->id)
            ->whereNull('stopped_at')
            ->exists();

        if ($alreadyRunning) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Timer is already running for this task']);
            }

            return back()->with('info', 'Timer is already running for this task.');
        }

        DB::transaction(function () use ($task, $user) {
            $now = now();

            TaskTimeLog::query()
                ->where('user_id', $user->id)
                ->whereNull('stopped_at')
                ->get()
                ->each(function (TaskTimeLog $log) use ($now) {
                    $startedAt = $log->started_at ?? $now;
                    $seconds = max(0, $startedAt->diffInSeconds($now, false));

                    $log->update([
                        'stopped_at' => $now,
                        'total_seconds' => $seconds,
                    ]);
                });

            TaskTimeLog::create([
                'task_id' => $task->id,
                'user_id' => $user->id,
                'started_at' => $now,
            ]);
        });

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Timer started']);
        }

        return back()->with('success', 'Timer started.');
    }

    public function stop(Request $request, Task $task)
    {
        $this->authorize('view', $task);

        $user = $request->user();

        $activeLog = TaskTimeLog::query()
            ->where('task_id', $task->id)
            ->where('user_id', $user->id)
            ->whereNull('stopped_at')
            ->latest('started_at')
            ->first();

        if ($activeLog) {
            $stoppedAt = now();
            $startedAt = $activeLog->started_at ?? $stoppedAt;
            $seconds = max(0, $startedAt->diffInSeconds($stoppedAt, false));

            $activeLog->update([
                'stopped_at' => $stoppedAt,
                'total_seconds' => $seconds,
            ]);

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Timer stopped']);
            }

            return back()->with('success', 'Timer stopped.');
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'No active timer found for this task.'], 422);
        }

        return back()->with('info', 'No active timer found for this task.');
    }
}
