<?php

namespace Database\Seeders;

use App\Modules\Automation\Models\AutomationRule;
use App\Modules\Shared\Enums\TaskStatus;
use Illuminate\Database\Seeder;

class AutomationRuleSeeder extends Seeder
{
    public function run(): void
    {
        AutomationRule::query()->updateOrCreate(
            ['name' => 'Overdue Escalation'],
            [
                'trigger_event' => 'scheduled.daily',
                'conditions' => [
                    'overdue_days_gt' => 3,
                    'status_not_in' => [TaskStatus::DONE->value],
                ],
                'actions' => [
                    ['type' => 'reassign_to_project_manager'],
                ],
                'is_active' => true,
            ]
        );

        AutomationRule::query()->updateOrCreate(
            ['name' => 'Stale Task Alert'],
            [
                'trigger_event' => 'scheduled.daily',
                'conditions' => [
                    'unchanged_days_gte' => 5,
                    'status_not_in' => [TaskStatus::DONE->value],
                ],
                'actions' => [
                    ['type' => 'notify_assignees', 'message' => 'Reminder: task has no status update for 5 days.'],
                ],
                'is_active' => true,
            ]
        );

        AutomationRule::query()->updateOrCreate(
            ['name' => 'Auto-Blocker'],
            [
                'trigger_event' => 'task.status_changed',
                'conditions' => [
                    'status_changed_to' => TaskStatus::BLOCKED->value,
                ],
                'actions' => [
                    ['type' => 'notify_project_manager_and_creator', 'message' => 'A task was moved to blocked status.'],
                ],
                'is_active' => true,
            ]
        );

        AutomationRule::query()->updateOrCreate(
            ['name' => 'Quality Check'],
            [
                'trigger_event' => 'task.status_changed',
                'conditions' => [
                    'status_changed_to' => TaskStatus::FOR_REVIEW->value,
                ],
                'actions' => [
                    ['type' => 'assign_to_project_owner'],
                ],
                'is_active' => true,
            ]
        );
    }
}
