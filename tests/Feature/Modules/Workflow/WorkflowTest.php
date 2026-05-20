<?php

use App\Modules\Identity\Models\User;
use App\Modules\Projects\Models\Project;
use App\Modules\Projects\Models\ProjectMember;
use App\Modules\Tasks\Models\Task;
use App\Modules\Workflow\Models\TaskActivityLog;
use App\Modules\Workflow\Services\WorkflowService;

function workflowContext(): object
{
    $workflowService = app(WorkflowService::class);
    $lead = User::factory()->create(['role' => 'lead']);
    $member = User::factory()->create(['role' => 'member']);
    $admin = User::factory()->create(['role' => 'admin']);
    $project = Project::factory()->create(['created_by' => $lead->id]);

    ProjectMember::create(['project_id' => $project->id, 'user_id' => $lead->id, 'role' => 'lead']);
    ProjectMember::create(['project_id' => $project->id, 'user_id' => $member->id, 'role' => 'member']);

    return (object) compact('workflowService', 'lead', 'member', 'admin', 'project');
}

describe('Workflow Module', function () {
    describe('Status Transitions', function () {
        test('todo_can_transition_to_in_progress', function () {
            $ctx = workflowContext();

            Task::factory()->create([
                'project_id' => $ctx->project->id,
                'status' => 'todo',
                'created_by' => $ctx->lead->id,
            ]);

            $isAllowed = $ctx->workflowService->isTransitionAllowed('todo', 'in_progress');

            expect($isAllowed)->toBeTrue();
        });

        test('todo_can_transition_to_blocked', function () {
            $ctx = workflowContext();

            Task::factory()->create([
                'project_id' => $ctx->project->id,
                'status' => 'todo',
                'created_by' => $ctx->lead->id,
            ]);

            $isAllowed = $ctx->workflowService->isTransitionAllowed('todo', 'blocked');

            expect($isAllowed)->toBeTrue();
        });

        test('invalid_status_transition_is_blocked_todo_to_done', function () {
            $ctx = workflowContext();

            Task::factory()->create([
                'project_id' => $ctx->project->id,
                'status' => 'todo',
                'created_by' => $ctx->lead->id,
            ]);

            $isAllowed = $ctx->workflowService->isTransitionAllowed('todo', 'done');

            expect($isAllowed)->toBeFalse();
        });

        test('invalid_status_transition_is_blocked_todo_to_for_review', function () {
            $ctx = workflowContext();

            Task::factory()->create([
                'project_id' => $ctx->project->id,
                'status' => 'todo',
                'created_by' => $ctx->lead->id,
            ]);

            $isAllowed = $ctx->workflowService->isTransitionAllowed('todo', 'for_review');

            expect($isAllowed)->toBeFalse();
        });

        test('in_progress_can_transition_to_blocked', function () {
            $ctx = workflowContext();
            $isAllowed = $ctx->workflowService->isTransitionAllowed('in_progress', 'blocked');

            expect($isAllowed)->toBeTrue();
        });

        test('in_progress_can_transition_to_for_review', function () {
            $ctx = workflowContext();
            $isAllowed = $ctx->workflowService->isTransitionAllowed('in_progress', 'for_review');

            expect($isAllowed)->toBeTrue();
        });

        test('blocked_can_transition_to_in_progress', function () {
            $ctx = workflowContext();
            $isAllowed = $ctx->workflowService->isTransitionAllowed('blocked', 'in_progress');

            expect($isAllowed)->toBeTrue();
        });

        test('for_review_can_transition_to_done', function () {
            $ctx = workflowContext();
            $isAllowed = $ctx->workflowService->isTransitionAllowed('for_review', 'done');

            expect($isAllowed)->toBeTrue();
        });

        test('for_review_can_transition_to_in_progress_if_rejected', function () {
            $ctx = workflowContext();
            $isAllowed = $ctx->workflowService->isTransitionAllowed('for_review', 'in_progress');

            expect($isAllowed)->toBeTrue();
        });

        test('done_cannot_transition', function () {
            $ctx = workflowContext();
            $transitions = $ctx->workflowService->getValidTransitions('done');

            expect($transitions)->toBeEmpty();
        });
    });

    describe('Authorization Rules', function () {
        test('member_cannot_complete_task', function () {
            $ctx = workflowContext();
            $task = Task::factory()->create([
                'project_id' => $ctx->project->id,
                'status' => 'for_review',
                'created_by' => $ctx->lead->id,
            ]);

            $canComplete = $ctx->workflowService->canUserCompleteTask($ctx->member, $task);

            expect($canComplete)->toBeFalse();
        });

        test('lead_can_complete_task', function () {
            $ctx = workflowContext();
            $task = Task::factory()->create([
                'project_id' => $ctx->project->id,
                'status' => 'for_review',
                'created_by' => $ctx->lead->id,
            ]);

            $canComplete = $ctx->workflowService->canUserCompleteTask($ctx->lead, $task);

            expect($canComplete)->toBeTrue();
        });

        test('admin_can_complete_task', function () {
            $ctx = workflowContext();
            $task = Task::factory()->create([
                'project_id' => $ctx->project->id,
                'status' => 'for_review',
                'created_by' => $ctx->lead->id,
            ]);

            $canComplete = $ctx->workflowService->canUserCompleteTask($ctx->admin, $task);

            expect($canComplete)->toBeTrue();
        });

        test('only_authorized_roles_can_complete_task', function () {
            $ctx = workflowContext();
            $task = Task::factory()->create([
                'project_id' => $ctx->project->id,
                'status' => 'for_review',
                'created_by' => $ctx->lead->id,
            ]);

            $canMemberComplete = $ctx->workflowService->canUserTransition($ctx->member, $task, 'done');
            $canLeadComplete = $ctx->workflowService->canUserTransition($ctx->lead, $task, 'done');
            $canAdminComplete = $ctx->workflowService->canUserTransition($ctx->admin, $task, 'done');

            expect($canMemberComplete)->toBeFalse();
            expect($canLeadComplete)->toBeTrue();
            expect($canAdminComplete)->toBeTrue();
        });
    });

    describe('Activity Logging', function () {
        test('activity_log_is_created_when_task_status_changes', function () {
            $ctx = workflowContext();
            $task = Task::factory()->create([
                'project_id' => $ctx->project->id,
                'status' => 'todo',
                'created_by' => $ctx->lead->id,
            ]);

            $ctx->workflowService->updateStatus($task, 'in_progress', $ctx->lead);

            test()->assertDatabaseHas('task_activity_logs', [
                'task_id' => $task->id,
                'actor_id' => $ctx->lead->id,
                'action_type' => 'status_change',
                'old_value' => 'todo',
                'new_value' => 'in_progress',
            ]);
        });

        test('activity_log_records_old_and_new_values', function () {
            $ctx = workflowContext();
            $task = Task::factory()->create([
                'project_id' => $ctx->project->id,
                'status' => 'in_progress',
                'created_by' => $ctx->lead->id,
            ]);

            $ctx->workflowService->updateStatus($task, 'for_review', $ctx->lead);

            $log = TaskActivityLog::where('task_id', $task->id)->latest()->first();

            expect($log->old_value)->toEqual('in_progress');
            expect($log->new_value)->toEqual('for_review');
            expect($log->actor_id)->toEqual($ctx->lead->id);
        });

        test('activity_log_preserves_falsy_string_values', function () {
            $ctx = workflowContext();
            $task = Task::factory()->create([
                'project_id' => $ctx->project->id,
                'status' => 'todo',
                'created_by' => $ctx->lead->id,
            ]);

            $ctx->workflowService->recordActivityLog(
                task: $task,
                actor: $ctx->lead,
                actionType: 'priority_change',
                oldValue: '0',
                newValue: false,
            );

            $log = TaskActivityLog::where('task_id', $task->id)->latest()->first();

            expect($log->old_value)->toEqual('0');
            expect($log->new_value)->toEqual('');
        });

        test('activity_log_has_correct_description', function () {
            $ctx = workflowContext();
            $task = Task::factory()->create([
                'project_id' => $ctx->project->id,
                'status' => 'todo',
                'created_by' => $ctx->lead->id,
            ]);

            $ctx->workflowService->updateStatus($task, 'blocked', $ctx->lead);

            /** @var TaskActivityLog $log */
            $log = TaskActivityLog::where('task_id', $task->id)->latest()->first();
            $description = $log->getDescription();

            expect($description)->toContain('todo');
            expect($description)->toContain('blocked');
        });

        test('multiple_activity_logs_are_recorded_in_order', function () {
            $ctx = workflowContext();
            $task = Task::factory()->create([
                'project_id' => $ctx->project->id,
                'status' => 'todo',
                'created_by' => $ctx->lead->id,
            ]);

            $ctx->workflowService->updateStatus($task, 'in_progress', $ctx->lead);
            $ctx->workflowService->updateStatus($task, 'for_review', $ctx->lead);
            $ctx->workflowService->updateStatus($task, 'done', $ctx->lead);

            $logs = TaskActivityLog::where('task_id', $task->id)->orderBy('created_at')->get();

            expect($logs)->toHaveCount(3);
            expect($logs[0]->new_value)->toEqual('in_progress');
            expect($logs[1]->new_value)->toEqual('for_review');
            expect($logs[2]->new_value)->toEqual('done');
        });
    });

    describe('API Endpoints', function () {
        test('can_update_task_status_via_api', function () {
            $ctx = workflowContext();
            $task = Task::factory()->create([
                'project_id' => $ctx->project->id,
                'status' => 'todo',
                'created_by' => $ctx->lead->id,
            ]);

            test()->actingAs($ctx->lead)->postJson(
                route('tasks.status.update', $task),
                ['status' => 'in_progress']
            )->assertOk()
                ->assertJsonStructure(['message', 'task']);

            test()->assertDatabaseHas('tasks', [
                'id' => $task->id,
                'status' => 'in_progress',
            ]);
        });

        test('cannot_perform_invalid_transition_via_api', function () {
            $ctx = workflowContext();
            $task = Task::factory()->create([
                'project_id' => $ctx->project->id,
                'status' => 'todo',
                'created_by' => $ctx->lead->id,
            ]);

            test()->actingAs($ctx->lead)->postJson(
                route('tasks.status.update', $task),
                ['status' => 'done']
            )->assertUnprocessable()
                ->assertJsonStructure(['message', 'current_status', 'requested_status', 'valid_transitions']);
        });

        test('member_cannot_complete_task_via_api', function () {
            $ctx = workflowContext();
            $task = Task::factory()->create([
                'project_id' => $ctx->project->id,
                'status' => 'for_review',
                'created_by' => $ctx->lead->id,
            ]);

            test()->actingAs($ctx->member)->postJson(
                route('tasks.status.update', $task),
                ['status' => 'done']
            )->assertForbidden();

            test()->assertDatabaseHas('tasks', [
                'id' => $task->id,
                'status' => 'for_review',
            ]);
        });

        test('test_member_cannot_bypass_review_gate', function () {
            $ctx = workflowContext();
            $task = Task::factory()->create([
                'project_id' => $ctx->project->id,
                'status' => 'for_review',
                'created_by' => $ctx->lead->id,
            ]);

            $response = test()->actingAs($ctx->member)->postJson(
                route('tasks.status.update', $task),
                ['status' => 'done']
            );

            $response
                ->assertForbidden()
                ->assertJson(['message' => 'Only manager or admin can approve task completion.']);

            test()->assertDatabaseHas('tasks', [
                'id' => $task->id,
                'status' => 'for_review',
            ]);
        });

        test('can_get_valid_transitions_for_task', function () {
            $ctx = workflowContext();
            $task = Task::factory()->create([
                'project_id' => $ctx->project->id,
                'status' => 'todo',
                'created_by' => $ctx->lead->id,
            ]);

            test()->actingAs($ctx->lead)->getJson(
                route('tasks.transitions', $task)
            )->assertOk()
                ->assertJsonStructure(['current_status', 'valid_transitions', 'available_statuses'])
                ->assertJson(['current_status' => 'todo']);
        });

        test('can_get_activity_timeline_for_task', function () {
            $ctx = workflowContext();
            $task = Task::factory()->create([
                'project_id' => $ctx->project->id,
                'status' => 'todo',
                'created_by' => $ctx->lead->id,
            ]);

            $ctx->workflowService->updateStatus($task, 'in_progress', $ctx->lead);

            test()->actingAs($ctx->lead)->getJson(
                route('tasks.activity.timeline', $task)
            )->assertOk()
                ->assertJsonStructure(['task_id', 'activity_count', 'activities'])
                ->assertJson(['task_id' => $task->id, 'activity_count' => 1]);
        });

        test('activity_timeline_shows_all_changes', function () {
            $ctx = workflowContext();
            $task = Task::factory()->create([
                'project_id' => $ctx->project->id,
                'status' => 'todo',
                'created_by' => $ctx->lead->id,
            ]);

            $ctx->workflowService->updateStatus($task, 'in_progress', $ctx->lead);
            $ctx->workflowService->updateStatus($task, 'for_review', $ctx->lead);

            $response = test()->actingAs($ctx->lead)->getJson(
                route('tasks.activity.timeline', $task)
            );

            $activities = $response->json('activities');

            expect($activities)->toHaveCount(2);
            expect($activities[0]['new_value'])->toEqual('for_review');
            expect($activities[1]['new_value'])->toEqual('in_progress');
        });

        test('unauthenticated_user_cannot_access_workflow_endpoints', function () {
            $ctx = workflowContext();
            $task = Task::factory()->create([
                'project_id' => $ctx->project->id,
                'status' => 'todo',
                'created_by' => $ctx->lead->id,
            ]);

            test()->postJson(route('tasks.status.update', $task), ['status' => 'in_progress'])
                ->assertUnauthorized();

            test()->getJson(route('tasks.transitions', $task))
                ->assertUnauthorized();

            test()->getJson(route('tasks.activity.timeline', $task))
                ->assertUnauthorized();
        });
    });
});
