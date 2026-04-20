<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SampleSalesTasksSeeder extends Seeder
{
    public function run(): void
    {
        $projectId = DB::table('projects')->value('id');
        $userId    = DB::table('users')->value('id');
        $now       = now();

        // Remove previous sample seeds if re-run
        DB::table('tasks')->whereIn('task_no', ['SALE-001', 'SALE-002'])->delete();

        DB::table('tasks')->insert([
            [
                'project_id'     => $projectId,
                'title'          => 'Client Proposal - Purefoods Laser Marking',
                'status'         => 'in_progress',
                'team_in_charge' => 'Sales',
                'priority'       => 'high',
                'due_date'       => $now->copy()->addDays(5)->format('Y-m-d'),
                'created_by'     => $userId,
                'task_no'        => 'SALE-001',
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'project_id'     => $projectId,
                'title'          => 'Quotation Follow-up - Robot Cleaner Project',
                'status'         => 'todo',
                'team_in_charge' => 'Sales',
                'priority'       => 'medium',
                'due_date'       => $now->copy()->addDays(10)->format('Y-m-d'),
                'created_by'     => $userId,
                'task_no'        => 'SALE-002',
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
        ]);

        $this->command->info('✓ Inserted 2 sample Sales tasks into project ID ' . $projectId);
    }
}
