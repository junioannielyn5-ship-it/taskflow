<?php

namespace App\Modules\Workflow\Http\Controllers;

use App\Modules\Tasks\Models\Task;
use App\Modules\Workflow\Models\TaskActivityLog;
use App\Modules\Workflow\Services\WorkflowService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class ActivityController
{
    /**
     * Create a new controller instance.
     */
    public function __construct(private WorkflowService $workflowService)
    {
    }

    /**
     * Get activity timeline for a task.
     *
     * GET /tasks/{id}/activity
     */
    public function timeline(Task $task): JsonResponse
    {
        if (Gate::denies('update-task-status', $task)) {
            return response()->json(['message' => 'You are not allowed to view activity for this task.'], 403);
        }

        $activities = $this->workflowService->getActivityTimeline($task);

        return response()->json([
            'task_id' => $task->id,
            'activity_count' => $activities->count(),
            'activities' => $activities->map(function (TaskActivityLog $activity) {
                $isAutomation = $this->isAutomationActor($activity);
                $actorName = $isAutomation ? 'TaskFlow Automations' : ($activity->actor?->name ?? 'Unknown User');

                return [
                    'id' => $activity->id,
                    'actor_id' => $activity->actor_id,
                    'actor_name' => $actorName,
                    'action_type' => $activity->action_type,
                    'old_value' => $activity->old_value,
                    'new_value' => $activity->new_value,
                    'created_at' => $activity->created_at?->toIso8601String(),
                    'created_at_human' => $activity->created_at?->diffForHumans(),
                    'action_text' => $this->buildActionText($activity, $actorName, $isAutomation),
                    'is_automation' => $isAutomation,
                    'badge' => $isAutomation ? 'Bot' : null,
                    'metadata' => $activity->metadata,
                ];
            })->values(),
        ]);
    }

    private function isAutomationActor(TaskActivityLog $activity): bool
    {
        return ((int) $activity->actor_id === 0)
            || (($activity->metadata['actor'] ?? null) === 'System')
            || (strtolower((string) $activity->actor?->name) === 'system')
            || in_array($activity->action_type, ['automation_escalation', 'automation_notification'], true);
    }

    private function buildActionText(TaskActivityLog $activity, string $actorName, bool $isAutomation): string
    {
        $oldValue = $activity->old_value ?: 'N/A';
        $newValue = $activity->new_value ?: 'N/A';

        return match ($activity->action_type) {
            'status_change' => "{$actorName} moved this task from {$oldValue} to {$newValue}",
            'assignee_change' => "{$actorName} assigned this task to {$newValue}",
            'priority_change' => "{$actorName} increased priority to {$newValue}",
            'comment_added', 'comment_created' => "{$actorName} added a comment",
            'automation_escalation' => 'TaskFlow Automations reassigned this task to Manager due to 3-day delay',
            default => $isAutomation
                ? "{$actorName}: {$activity->getDescription()}"
                : "{$actorName} {$activity->getDescription()}",
        };
    }
}
