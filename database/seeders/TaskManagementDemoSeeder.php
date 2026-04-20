<?php

namespace Database\Seeders;

use App\Modules\Identity\Models\User;
use App\Modules\Projects\Models\Project;
use App\Modules\Projects\Models\ProjectMember;
use App\Modules\Tasks\Models\Task;
use Illuminate\Database\Seeder;

class TaskManagementDemoSeeder extends Seeder
{
    /**
     * Seed demo data for dashboard charts and task workflows.
     */
    public function run(): void
    {
        $demoProjectNames = [
            'Operations Planning',
            'Client Success Improvements',
            'Internal Tools Enhancement',
            'Product Release Readiness',
            'Quality Assurance Initiative',
            'Reporting and Analytics',
            'Marketing Enablement',
            'Support Process Optimization',
            'Engineering Backlog Cleanup',
            'Security Compliance Rollout',
        ];

        $users = User::query()->get();

        if ($users->count() < 8) {
            $users = User::query()->get()->merge(
                User::factory()->count(8 - $users->count())->create()
            );
        }

        for ($projectIndex = 0; $projectIndex < 10; $projectIndex++) {
            $creator = $users->random();

            $project = Project::factory()->active()->create([
                'name' => $demoProjectNames[$projectIndex],
                'description' => 'Demo project for dashboard charts and task management workflows.',
                'created_by' => $creator->id,
            ]);

            ProjectMember::updateOrCreate(
                ['project_id' => $project->id, 'user_id' => $creator->id],
                ['role' => 'lead']
            );

            $extraMembers = $users
                ->where('id', '!=', $creator->id)
                ->shuffle()
                ->take(rand(2, 4));

            foreach ($extraMembers as $member) {
                ProjectMember::updateOrCreate(
                    ['project_id' => $project->id, 'user_id' => $member->id],
                    ['role' => 'member']
                );
            }

            $projectMemberIds = ProjectMember::where('project_id', $project->id)->pluck('user_id');

            for ($taskIndex = 0; $taskIndex < 5; $taskIndex++) {
                $status = collect(['todo', 'in_progress', 'for_review', 'done', 'blocked'])->random();
                $dueDate = fake()->dateTimeBetween('-2 days', '+10 days');

                $task = Task::factory()->create([
                    'project_id' => $project->id,
                    'created_by' => $projectMemberIds->random(),
                    'priority' => collect(['low', 'medium', 'high', 'urgent'])->random(),
                    'status' => $status,
                    'due_date' => $dueDate,
                ]);

                $assigneeIds = $projectMemberIds->shuffle()->take(rand(1, min(3, $projectMemberIds->count())));
                foreach ($assigneeIds as $assigneeId) {
                    $assignee = $users->firstWhere('id', $assigneeId);
                    if ($assignee) {
                        $task->assign($assignee);
                    }
                }
            }
        }
    }
}
