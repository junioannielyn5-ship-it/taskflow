<?php

namespace App\Modules\Workflow\Http\Controllers;

use App\Modules\Shared\Enums\TaskStatus;
use App\Modules\Tasks\Models\Task;
use App\Modules\Workflow\Services\WorkflowService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class TaskStatusController
{
    /**
     * Create a new controller instance.
     */
    public function __construct(private WorkflowService $workflowService)
    {
    }

    /**
     * Update task status with validation.
     *
     * POST /tasks/{id}/status
     */
    public function update(Request $request, Task $task): JsonResponse|RedirectResponse
    {
        if ($request->has('status')) {
            $request->merge([
                'status' => TaskStatus::normalize($request->input('status')),
            ]);
        }

        $validated = $request->validate([
            'status' => ['required', 'string', Rule::in(TaskStatus::workflowValues())],
            'reason' => ['nullable', 'string', 'max:500'],
        ]);

        $user = Auth::user();

        $respondForbidden = function (string $message) use ($request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => $message], 403);
            }

            return back()->withErrors(['status' => $message]);
        };

        $respondUnprocessable = function (string $message, array $extra = []) use ($request) {
            if ($request->expectsJson()) {
                return response()->json(array_merge(['message' => $message], $extra), 422);
            }

            return back()->withErrors(['status' => $message]);
        };

        $respondOk = function (string $message) use ($request, $task) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $message,
                    'task' => $task,
                ]);
            }

            return redirect()->route('tasks.show', $task)->with('success', $message);
        };

        if (Gate::denies('update-task-status', $task)) {
            return $respondForbidden('You are not allowed to update this task status.');
        }

        if ($validated['status'] === 'done' && Gate::denies('complete-task', $task)) {
            return $respondForbidden('Only manager or admin can approve task completion.');
        }

        $requestedStatus = $validated['status'];

        if ($requestedStatus === TaskStatus::IN_PROGRESS->value && $task->status === TaskStatus::IN_PROGRESS->value) {
            return $respondOk('Task is already in progress.');
        }

        $statusSequence = [$requestedStatus];

        foreach ($statusSequence as $nextStatus) {
            if ($nextStatus === $task->status) {
                continue;
            }

            if (!$this->workflowService->canUserTransition($user, $task, $nextStatus)) {
                return $respondUnprocessable(
                    'This status transition is not allowed from ' . $task->status,
                    [
                        'current_status' => $task->status,
                        'requested_status' => $nextStatus,
                        'valid_transitions' => $this->workflowService->getValidTransitions($task->status),
                    ]
                );
            }

            if (!$this->workflowService->updateStatus($task, $nextStatus, $user, $validated['reason'] ?? null)) {
                return $respondUnprocessable(
                    $nextStatus === TaskStatus::BLOCKED->value
                        ? 'Blocked status requires a reason and valid transition.'
                        : 'Unable to update task status.'
                );
            }

            $task->refresh();
        }

        return $respondOk('Task status updated successfully');
    }

    /**
     * Get valid transitions for the current status.
     *
     * GET /tasks/{id}/transitions
     */
    public function getTransitions(Task $task): JsonResponse
    {
        $user = Auth::user();

        if (Gate::denies('update-task-status', $task)) {
            return response()->json(['message' => 'You are not allowed to view transitions for this task.'], 403);
        }

        return response()->json([
            'current_status' => $task->status,
            'valid_transitions' => $this->workflowService->getValidTransitions($task->status),
            'available_statuses' => $this->workflowService->getAvailableStatuses(),
            'can_complete' => Gate::allows('complete-task', $task),
        ]);
    }
}
