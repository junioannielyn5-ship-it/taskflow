<?php

namespace App\Modules\Automation\Services;

use App\Modules\Automation\Models\AutomationRule;
use App\Modules\Automation\Notifications\AutomationAlertNotification;
use App\Modules\Identity\Models\User;
use App\Modules\Tasks\Models\Task;
use App\Modules\Workflow\Models\TaskActivityLog;
use Illuminate\Support\Arr;

class RuleEngine
{
    public function __construct(private SystemActorResolver $systemActorResolver)
    {
    }

    public function evaluate(AutomationRule $rule, Task $task, array $context = []): bool
    {
        $conditions = $rule->conditions ?? [];

        if (!is_array($conditions) || $conditions === []) {
            return true;
        }

        if (isset($conditions['status_not']) && $task->status === $conditions['status_not']) {
            return false;
        }

        if (isset($conditions['status_not_in']) && in_array($task->status, (array) $conditions['status_not_in'], true)) {
            return false;
        }

        if (isset($conditions['status_equals']) && $task->status !== $conditions['status_equals']) {
            return false;
        }

        if (isset($conditions['status_changed_to'])) {
            $toStatus = Arr::get($context, 'to_status');
            if ($toStatus !== $conditions['status_changed_to']) {
                return false;
            }
        }

        if (isset($conditions['overdue_days_gt'])) {
            if (!$task->due_date) {
                return false;
            }

            $daysOverdue = now()->startOfDay()->diffInDays($task->due_date->startOfDay(), false) * -1;
            if ($daysOverdue <= (int) $conditions['overdue_days_gt']) {
                return false;
            }
        }

        if (isset($conditions['unchanged_days_gte'])) {
            $unchangedDays = now()->startOfDay()->diffInDays($task->updated_at->startOfDay());
            if ($unchangedDays < (int) $conditions['unchanged_days_gte']) {
                return false;
            }
        }

        return true;
    }

    public function execute(AutomationRule $rule, Task $task, array $context = []): void
    {
        $actions = $rule->actions ?? [];
        if (!is_array($actions)) {
            return;
        }

        foreach ($actions as $action) {
            $this->executeAction($task, $action, $rule, $context);
        }
    }

    private function executeAction(Task $task, mixed $action, AutomationRule $rule, array $context): void
    {
        $type = is_array($action) ? ($action['type'] ?? null) : $action;
        if (!$type) {
            return;
        }

        match ($type) {
            'reassign_to_project_manager' => $this->reassignToProjectManager($task, $rule),
            'notify_manager' => $this->notifyManagers($task, $rule, (string) ($action['message'] ?? 'Automation alert for task '.$task->title)),
            'notify_project_manager_and_creator' => $this->notifyProjectManagerAndCreator($task, $rule, (string) ($action['message'] ?? 'Task was moved to blocked status.')),
            'notify_assignees' => $this->notifyAssignees($task, $rule, (string) ($action['message'] ?? 'Task reminder: please update status for '.$task->title)),
            'assign_to_project_owner' => $this->assignToProjectOwner($task, $rule),
            default => null,
        };
    }

    private function reassignToProjectManager(Task $task, AutomationRule $rule): void
    {
        $projectManager = $task->project
            ->members()
            ->with('user')
            ->get()
            ->pluck('user')
            ->filter()
            ->first(fn (User $user) => $user->hasAnyRole(['manager', 'project_manager', 'pm', 'admin']));

        if (!$projectManager) {
            $projectManager = User::query()
                ->whereIn('role', ['manager', 'project_manager', 'pm', 'admin'])
                ->orderBy('id')
                ->first();
        }

        if (!$projectManager) {
            return;
        }

        $oldAssigneeIds = $task->assignees()->pluck('users.id')->map(fn ($id) => (int) $id)->sort()->values()->all();
        $task->assignees()->sync([$projectManager->id]);
        $newAssigneeIds = $task->assignees()->pluck('users.id')->map(fn ($id) => (int) $id)->sort()->values()->all();

        $projectManager->notify(new AutomationAlertNotification("System: {$task->title} has been escalated to you due to 3-day delay", $task));

        $this->recordSystemActivity(
            task: $task,
            actionType: 'automation_escalation',
            oldValue: json_encode($oldAssigneeIds),
            newValue: 'System: Auto-escalated due to 3-day delay',
            metadata: [
                'rule' => $rule->name,
                'action' => 'reassign_to_project_manager',
                'new_assignee_ids' => $newAssigneeIds,
            ]
        );
    }

    private function notifyManagers(Task $task, AutomationRule $rule, string $message): void
    {
        $managerIds = User::query()
            ->whereIn('role', ['manager', 'admin'])
            ->pluck('id');

        if ($managerIds->isEmpty()) {
            return;
        }

        User::query()->whereIn('id', $managerIds)->get()->each(
            fn (User $user) => $user->notify(new AutomationAlertNotification($message, $task))
        );

        $this->recordSystemActivity(
            task: $task,
            actionType: 'automation_notification',
            oldValue: null,
            newValue: 'manager_notified',
            metadata: ['rule' => $rule->name, 'action' => 'notify_manager']
        );
    }

    private function notifyAssignees(Task $task, AutomationRule $rule, string $message): void
    {
        $task->assignees->each(fn (User $assignee) => $assignee->notify(new AutomationAlertNotification($message, $task)));

        $this->recordSystemActivity(
            task: $task,
            actionType: 'automation_notification',
            oldValue: null,
            newValue: 'assignees_notified',
            metadata: ['rule' => $rule->name, 'action' => 'notify_assignees']
        );
    }

    private function notifyProjectManagerAndCreator(Task $task, AutomationRule $rule, string $message): void
    {
        $projectManagers = $task->project
            ->members()
            ->with('user')
            ->get()
            ->pluck('user')
            ->filter()
            ->filter(fn (User $user) => $user->hasAnyRole(['manager', 'project_manager', 'pm', 'admin']))
            ->keyBy('id');

        $creator = User::query()->find($task->created_by);
        if ($creator) {
            $projectManagers->put($creator->id, $creator);
        }

        if ($projectManagers->isEmpty()) {
            $fallbackManagers = User::query()
                ->whereIn('role', ['manager', 'project_manager', 'pm', 'admin'])
                ->get()
                ->keyBy('id');
            $projectManagers = $projectManagers->merge($fallbackManagers);
        }

        $projectManagers->each(fn (User $user) => $user->notify(new AutomationAlertNotification($message, $task)));

        $this->recordSystemActivity(
            task: $task,
            actionType: 'automation_notification',
            oldValue: null,
            newValue: 'project_manager_and_creator_notified',
            metadata: ['rule' => $rule->name, 'action' => 'notify_project_manager_and_creator']
        );
    }

    private function assignToProjectOwner(Task $task, AutomationRule $rule): void
    {
        $ownerId = (int) $task->project->created_by;
        if ($ownerId <= 0) {
            return;
        }

        $oldAssigneeIds = $task->assignees()->pluck('users.id')->map(fn ($id) => (int) $id)->sort()->values()->all();
        $task->assignees()->syncWithoutDetaching([$ownerId]);
        $newAssigneeIds = $task->assignees()->pluck('users.id')->map(fn ($id) => (int) $id)->sort()->values()->all();

        $this->recordSystemActivity(
            task: $task,
            actionType: 'assignee_change',
            oldValue: json_encode($oldAssigneeIds),
            newValue: json_encode($newAssigneeIds),
            metadata: ['rule' => $rule->name, 'action' => 'assign_to_project_owner']
        );
    }

    private function recordSystemActivity(
        Task $task,
        string $actionType,
        ?string $oldValue,
        ?string $newValue,
        array $metadata = []
    ): void {
        $systemUser = $this->systemActorResolver->resolve();

        TaskActivityLog::query()->create([
            'task_id' => $task->id,
            'actor_id' => $systemUser->id,
            'action_type' => $actionType,
            'old_value' => $oldValue,
            'new_value' => $newValue,
            'metadata' => array_merge($metadata, ['actor' => 'System']),
        ]);
    }
}
