<?php

declare(strict_types=1);

use App\Modules\Identity\Models\User;
use App\Modules\Projects\Models\Project;
use App\Modules\Projects\Models\ProjectMember;
use App\Modules\Tasks\Models\Task;
use App\Modules\Workflow\Models\TaskActivityLog;

// Feature tests for Reporting Module

describe('Reporting Module', function () {
    beforeEach(function () {
        $this->user = User::factory()->create();
        $this->project = Project::factory()->create(['created_by' => $this->user->id]);
        ProjectMember::create(['project_id' => $this->project->id, 'user_id' => $this->user->id, 'role' => 'member']);
        $this->task = Task::factory()->create([
            'project_id' => $this->project->id,
            'created_by' => $this->user->id,
            'due_date' => now()->subDays(2),
            'status' => 'in_progress',
        ]);
    });

    test('reporting only includes projects user has access to', function () {
        $otherUser = User::factory()->create();
        $otherProject = Project::factory()->create(['created_by' => $otherUser->id]);
        $this->actingAs($this->user);
        $response = $this->getJson("/reports/overdue?project_id={$otherProject->id}");
        $response->assertStatus(200);
        $this->assertCount(0, $response->json('data'));
    });

    test('overdue report returns correct data', function () {
        $this->actingAs($this->user);
        $response = $this->getJson("/reports/overdue?project_id={$this->project->id}");
        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data'));
        $this->assertEquals($this->task->id, $response->json('data.0.id'));
    });

    test('cycle time calculation logic', function () {
        $this->actingAs($this->user);
        $doneTask = Task::factory()->create([
            'project_id' => $this->project->id,
            'created_by' => $this->user->id,
            'status' => 'done',
        ]);
        TaskActivityLog::factory()->create([
            'task_id' => $doneTask->id,
            'new_status' => 'in_progress',
            'created_at' => now()->subDays(5),
        ]);
        TaskActivityLog::factory()->create([
            'task_id' => $doneTask->id,
            'new_status' => 'done',
            'created_at' => now(),
        ]);
        $response = $this->getJson("/reports/cycle-time?project_id={$this->project->id}");
        $response->assertStatus(200);
        $this->assertEquals(5, $response->json('data.average_days'));
    });
});
