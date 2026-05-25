<?php

namespace App\Modules\Tasks\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Notifications\Notifications\TaskChecklistUpdatedNotification;
use App\Modules\Tasks\Models\Task;
use App\Modules\Tasks\Models\TaskChecklistItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskChecklistController extends Controller
{
    public function store(Request $request, Task $task): RedirectResponse
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
        ]);

        $task->checklistItems()->create([
            'title' => $validated['title'],
        ]);

        return redirect()->route('tasks.show', $task)->with('success', 'Checklist item added.');
    }

    public function toggle(Request $request, Task $task, TaskChecklistItem $item): RedirectResponse
    {
        $this->authorize('update', $task);

        abort_if($item->task_id !== $task->id, 404);

        $isCompleted = !$item->is_completed;

        $item->update([
            'is_completed' => $isCompleted,
            'completed_at' => $isCompleted ? now() : null,
            'completed_by' => $isCompleted ? Auth::id() : null,
        ]);

        $task->loadMissing('assignees');
        $actorName = Auth::user()?->name;

        $assignees = $task->relationLoaded('assignees') ? $task->getRelation('assignees') : $task->assignees()->get();

        foreach ($assignees as $assignee) {
            try {
                $assignee->notify(new TaskChecklistUpdatedNotification($task, $item->fresh(), $isCompleted, $actorName));
            } catch (\Throwable $e) {
                Log::error('Failed to send checklist notification: ' . $e->getMessage());
            }
        }

        return redirect()->route('tasks.show', $task)->with('success', 'Checklist updated.');
    }

    public function destroy(Task $task, TaskChecklistItem $item): RedirectResponse
    {
        $this->authorize('update', $task);

        abort_if($item->task_id !== $task->id, 404);

        $item->delete();

        return redirect()->route('tasks.show', $task)->with('success', 'Checklist item removed.');
    }
}
