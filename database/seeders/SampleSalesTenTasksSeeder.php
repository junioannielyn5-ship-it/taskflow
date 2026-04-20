<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SampleSalesTenTasksSeeder extends Seeder
{
    public function run(): void
    {
        $projectId = DB::table('projects')->value('id');
        $userId = DB::table('users')->value('id');
        $now = now();

        if (! $projectId || ! $userId) {
            $this->command->warn('No project or user found. Seeder skipped.');
            return;
        }

        // Clean previous demo Sales tasks so re-run stays predictable.
        DB::table('tasks')->where('task_no', 'like', 'SALE-DEMO-%')->delete();

        $statuses = [
            'done',
            'done',
            'done',
            'for_review',
            'in_progress',
            'in_progress',
            'todo',
            'todo',
            'todo',
            'todo',
        ];

        $rows = [];

        for ($i = 1; $i <= 10; $i++) {
            $taskNo = 'SALE-DEMO-' . str_pad((string) $i, 3, '0', STR_PAD_LEFT);
            $status = $statuses[$i - 1];

            $rows[] = [
                'project_id' => $projectId,
                'title' => 'Sales Demo Task ' . $i,
                'status' => $status,
                'team_in_charge' => 'Sales',
                'priority' => $i <= 3 ? 'high' : 'medium',
                'due_date' => $now->copy()->addDays($i)->format('Y-m-d'),
                'created_by' => $userId,
                'task_no' => $taskNo,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('tasks')->insert($rows);

        $summary = DB::table('tasks')
            ->selectRaw('status, COUNT(*) as total')
            ->where('task_no', 'like', 'SALE-DEMO-%')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $this->command->info('Inserted 10 sample Sales tasks into project ID ' . $projectId);
        $this->command->info('Status summary: ' . json_encode($summary));
    }
}
