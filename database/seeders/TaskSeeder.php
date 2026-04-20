<?php

namespace Database\Seeders;

use App\Modules\Identity\Models\User;
use App\Modules\Projects\Models\Project;
use App\Modules\Projects\Models\ProjectMember;
use App\Modules\Tasks\Models\Task;
use App\Modules\Workflow\Models\TaskActivityLog;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Seed tasks and assignees for dashboard/demo charts.
     */
    public function run(): void
    {
        $users = User::query()->get();
        $projects = Project::query()->get();

        if ($projects->isEmpty() || $users->isEmpty()) {
            return;
        }

        $this->ensureEachUserHasProjectMembership($users, $projects);

        $statuses = ['todo', 'in_progress', 'for_review', 'done'];
        $priorities = ['low', 'medium', 'high', 'urgent'];

        foreach (range(1, 20) as $index) {
            $creator = $users->random();
            $status = $statuses[array_rand($statuses)];

            $task = Task::query()->create([
                'project_id' => $projects->random()->id,
                'title' => 'Sample Task '.$index,
                'description' => 'Description for task '.$index,
                'task_process' => collect(['For Support', 'For Quote', 'Endorsed', 'For Approval'])->random(),
                'company' => collect(['PBI', 'TOYOTA', 'Splash', 'Movaflex'])->random(),
                'status' => $status,
                'priority' => $priorities[array_rand($priorities)],
                'date_received' => now()->subDays(rand(1, 14)),
                'date_started' => now()->subDays(rand(0, 10)),
                'due_date' => now()->addDays(rand(-5, 10)),
                'created_by' => $creator->id,
            ]);

            $assigneeIds = $users
                ->random(rand(1, min(3, $users->count())))
                ->pluck('id')
                ->unique()
                ->values()
                ->toArray();

            $task->assignees()->syncWithoutDetaching($assigneeIds);

            TaskActivityLog::query()->create([
                'task_id' => $task->id,
                'actor_id' => $creator->id,
                'action_type' => 'created',
                'new_value' => $status,
                'metadata' => [
                    'source' => 'TaskSeeder',
                    'assignee_ids' => $assigneeIds,
                ],
            ]);
        }
    }

    private function ensureEachUserHasProjectMembership($users, $projects): void
    {
        foreach ($users as $user) {
            $hasAccess = Project::query()
                ->where('created_by', $user->id)
                ->orWhereHas('members', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->exists();

            if ($hasAccess) {
                continue;
            }

            ProjectMember::query()->updateOrCreate(
                [
                    'project_id' => $projects->random()->id,
                    'user_id' => $user->id,
                ],
                ['role' => 'member']
            );
        }
    }
}
