<?php

describe('Task Workflow & Activity Log', function () {
    // No use statements in Pest describe block

    beforeEach(function () {
           $this->user = \App\Modules\Identity\Models\User::factory()->create();
           \Pest\Laravel\actingAs($this->user);
           $project = \App\Modules\Projects\Models\Project::factory()->create([
               'created_by' => $this->user->id,
           ]);

           \App\Modules\Projects\Models\ProjectMember::create([
               'project_id' => $project->id,
               'user_id' => $this->user->id,
               'role' => 'lead',
           ]);

           $this->task = \App\Modules\Tasks\Models\Task::factory()->create([
               'project_id' => $project->id,
               'created_by' => $this->user->id,
               'status' => 'todo',
           ]);
    });

    it('logs activity when status changes', function () {
           $this->task->status = 'in_progress';
           $this->task->save();
        expect(\App\Modules\Workflow\Models\TaskActivityLog::where('task_id', $this->task->id)->where('action_type', 'status_change')->exists())->toBeTrue();
    });

    it('requires comment when blocking a task', function () {
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $service = app(\App\Modules\Workflow\Services\TaskWorkflowService::class);
        $service->transition($this->task, 'blocked', $this->user, null);
    });

    it('allows valid status transitions', function () {
        $service = app(\App\Modules\Workflow\Services\TaskWorkflowService::class);
        $service->transition($this->task, 'in_progress', $this->user);
        expect($this->task->fresh()->status)->toBe('in_progress');
    });

    it('prevents invalid status transitions', function () {
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $service = app(\App\Modules\Workflow\Services\TaskWorkflowService::class);
        $service->transition($this->task, 'done', $this->user);
    });

    it('returns activity log via endpoint', function () {
        $this->task->status = 'in_progress';
        $this->task->save();
        $response = $this->getJson("/api/tasks/{$this->task->id}/activity");
        $response->assertOk();
        $response->assertJsonFragment(['action_type' => 'status_change']);
    });
});
