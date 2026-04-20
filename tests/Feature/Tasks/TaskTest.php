<?php

use App\Modules\Identity\Models\User;
use App\Modules\Projects\Models\Project;
use App\Modules\Projects\Models\ProjectMember;
use App\Modules\Tasks\Events\TaskCreated;
use App\Modules\Tasks\Events\TaskStatusChanged;
use App\Modules\Tasks\Models\Task;
use Illuminate\Support\Facades\Event;

function validTaskPayload(int $assigneeId, array $overrides = []): array
{
    return array_merge([
        'title' => 'New Task',
        'description' => 'Task description',
        'priority' => 'high',
        'assignees' => [$assigneeId],
        'task_process' => 'Pre-Sales',
        'specific_process' => 'Product - Quotation',
        'company' => 'Test Company',
        'team_in_charge' => 'Ronnel Gusi',
        'date_received' => now()->toDateString(),
        'date_started' => now()->toDateString(),
    ], $overrides);
}

describe('TaskController', function () {
    describe('task creation', function () {
        test('authorized_project_member_can_create_task', function () {
            $member = User::factory()->create(['role' => 'member']);
            $project = Project::factory()->create(['created_by' => $member->id]);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $member->id, 'role' => 'lead']);

            $this->actingAs($member)->postJson(
                route('tasks.store', $project),
                validTaskPayload($member->id)
            )->assertCreated();

            $this->assertDatabaseHas('tasks', [
                'project_id' => $project->id,
                'title' => 'New Task',
            ]);
        });

        test('non_project_member_cannot_create_task', function () {
            $member = User::factory()->create(['role' => 'member']);
            $nonMember = User::factory()->create(['role' => 'member']);

            $project = Project::factory()->create(['created_by' => $member->id]);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $member->id, 'role' => 'lead']);

            $this->actingAs($nonMember)->postJson(
                route('tasks.store', $project),
                ['title' => 'New Task']
            )->assertForbidden();

            $this->assertDatabaseCount('tasks', 0);
        });

        test('task_requires_title', function () {
            $member = User::factory()->create(['role' => 'member']);
            $project = Project::factory()->create(['created_by' => $member->id]);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $member->id, 'role' => 'lead']);

            $this->actingAs($member)->postJson(
                route('tasks.store', $project),
                validTaskPayload($member->id, [
                    'title' => null,
                    'description' => 'No title task',
                ])
            )->assertUnprocessable()
             ->assertJsonValidationErrors('title');
        });

        test('unauthenticated_user_cannot_create_task', function () {
            $project = Project::factory()->create();

            $this->postJson(
                route('tasks.store', $project),
                ['title' => 'New Task']
            )->assertUnauthorized();
        });

        test('can_create_task_with_dependency_in_same_project', function () {
            $member = User::factory()->create(['role' => 'member']);
            $project = Project::factory()->create(['created_by' => $member->id]);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $member->id, 'role' => 'lead']);

            $blockingTask = Task::factory()->create([
                'project_id' => $project->id,
                'created_by' => $member->id,
            ]);

            $this->actingAs($member)->postJson(
                route('tasks.store', $project),
                validTaskPayload($member->id, [
                    'title' => 'Blocked task',
                    'blocked_by_task_id' => $blockingTask->id,
                    'status' => 'blocked',
                ])
            )->assertCreated();

            $this->assertDatabaseHas('tasks', [
                'project_id' => $project->id,
                'title' => 'Blocked task',
                'blocked_by_task_id' => $blockingTask->id,
            ]);
        });

        test('cannot_create_task_with_dependency_from_other_project', function () {
            $member = User::factory()->create(['role' => 'member']);
            $project = Project::factory()->create(['created_by' => $member->id]);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $member->id, 'role' => 'lead']);

            $otherProject = Project::factory()->create(['created_by' => $member->id]);
            ProjectMember::create(['project_id' => $otherProject->id, 'user_id' => $member->id, 'role' => 'lead']);

            $otherProjectTask = Task::factory()->create([
                'project_id' => $otherProject->id,
                'created_by' => $member->id,
            ]);

            $this->actingAs($member)->postJson(
                route('tasks.store', $project),
                validTaskPayload($member->id, [
                    'title' => 'Invalid dependency task',
                    'blocked_by_task_id' => $otherProjectTask->id,
                ])
            )->assertUnprocessable()->assertJsonValidationErrors('blocked_by_task_id');
        });
    });

    describe('task filtering', function () {
        test('can_filter_tasks_by_status_and_assignee', function () {
            $member1 = User::factory()->create(['role' => 'member']);
            $member2 = User::factory()->create(['role' => 'member']);
            $project = Project::factory()->create(['created_by' => $member1->id]);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $member1->id, 'role' => 'lead']);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $member2->id, 'role' => 'member']);

            // Create tasks with different statuses
            $task1 = Task::factory()->create([
                'project_id' => $project->id,
                'status' => 'todo',
                'created_by' => $member1->id,
            ]);
            $task1->assign($member1);

            $task2 = Task::factory()->create([
                'project_id' => $project->id,
                'status' => 'in_progress',
                'created_by' => $member1->id,
            ]);
            $task2->assign($member2);

            $task3 = Task::factory()->create([
                'project_id' => $project->id,
                'status' => 'done',
                'created_by' => $member1->id,
            ]);

            // Filter by status
            $response = $this->actingAs($member1)->getJson(
                route('tasks.index', $project) . '?status=todo'
            );
            $response->assertOk();
            expect($response->json('count'))->toBe(1);

            // Filter by status and assignee
            $response = $this->actingAs($member1)->getJson(
                route('tasks.index', $project) . '?status=in_progress&assignee=' . $member2->id
            );
            $response->assertOk();
            expect($response->json('count'))->toBe(1);

            // Filter by priority
            $task4 = Task::factory()->create([
                'project_id' => $project->id,
                'priority' => 'urgent',
            ]);

            $response = $this->actingAs($member1)->getJson(
                route('tasks.index', $project) . '?priority=urgent'
            );
            $response->assertOk();
            expect($response->json('count'))->toBe(1);
        });

        test('can_search_tasks', function () {
            $member = User::factory()->create(['role' => 'member']);
            $project = Project::factory()->create(['created_by' => $member->id]);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $member->id, 'role' => 'lead']);

            Task::factory()->create([
                'project_id' => $project->id,
                'title' => 'Fix login bug',
                'created_by' => $member->id,
            ]);

            Task::factory()->create([
                'project_id' => $project->id,
                'title' => 'Design dashboard',
                'created_by' => $member->id,
            ]);

            $response = $this->actingAs($member)->getJson(
                route('tasks.index', $project) . '?search=login'
            );
            $response->assertOk();
            expect($response->json('count'))->toBe(1);
        });

        test('can_filter_overdue_tasks', function () {
            $member = User::factory()->create(['role' => 'member']);
            $project = Project::factory()->create(['created_by' => $member->id]);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $member->id, 'role' => 'lead']);

            // Overdue task (not done)
            Task::factory()->overdue()->create([
                'project_id' => $project->id,
                'created_by' => $member->id,
            ]);

            // Future task
            Task::factory()->create([
                'project_id' => $project->id,
                'created_by' => $member->id,
            ]);

            // Overdue but done (should not appear)
            Task::factory()->overdue()->done()->create([
                'project_id' => $project->id,
                'created_by' => $member->id,
            ]);

            $response = $this->actingAs($member)->getJson(
                route('tasks.index', $project) . '?overdue=1'
            );
            $response->assertOk();
            expect($response->json('count'))->toBe(1);
        });

        test('can_filter_tasks_by_dependency', function () {
            $member = User::factory()->create(['role' => 'member']);
            $project = Project::factory()->create(['created_by' => $member->id]);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $member->id, 'role' => 'lead']);

            $blockingTask = Task::factory()->create([
                'project_id' => $project->id,
                'created_by' => $member->id,
            ]);

            Task::factory()->create([
                'project_id' => $project->id,
                'created_by' => $member->id,
                'blocked_by_task_id' => $blockingTask->id,
                'status' => 'blocked',
            ]);

            Task::factory()->create([
                'project_id' => $project->id,
                'created_by' => $member->id,
                'blocked_by_task_id' => null,
            ]);

            $response = $this->actingAs($member)->getJson(
                route('tasks.index', $project) . '?blocked_by_task_id=' . $blockingTask->id
            );

            $response->assertOk();
            expect($response->json('count'))->toBe(1);
        });
    });

    describe('task updates and events', function () {
        test('task_update_emits_event_instead_of_logging_directly', function () {
            Event::fake([TaskStatusChanged::class]);

            $member = User::factory()->create(['role' => 'member']);
            $project = Project::factory()->create(['created_by' => $member->id]);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $member->id, 'role' => 'lead']);

            $task = Task::factory()->create([
                'project_id' => $project->id,
                'status' => 'todo',
                'created_by' => $member->id,
            ]);

            $this->actingAs($member)->putJson(
                route('tasks.update', $task),
                ['status' => 'in_progress']
            )->assertOk()
             ->assertJsonPath('status_changed', true);

            Event::assertDispatched(TaskStatusChanged::class);
        });

        test('task_creation_emits_created_event', function () {
            Event::fake([TaskCreated::class]);

            $member = User::factory()->create(['role' => 'member']);
            $project = Project::factory()->create(['created_by' => $member->id]);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $member->id, 'role' => 'lead']);

            $this->actingAs($member)->postJson(
                route('tasks.store', $project),
                validTaskPayload($member->id)
            )->assertCreated();

            Event::assertDispatched(TaskCreated::class);
        });

        test('only_authorized_users_can_update_task', function () {
            $creator = User::factory()->create(['role' => 'member']);
            $member = User::factory()->create(['role' => 'member']);
            $nonMember = User::factory()->create(['role' => 'member']);

            $project = Project::factory()->create(['created_by' => $creator->id]);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $creator->id, 'role' => 'lead']);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $member->id, 'role' => 'member']);

            $task = Task::factory()->create([
                'project_id' => $project->id,
                'created_by' => $creator->id,
            ]);

            // Creator can update
            $this->actingAs($creator)->putJson(
                route('tasks.update', $task),
                ['title' => 'Updated']
            )->assertOk();

            // Member can update
            $this->actingAs($member)->putJson(
                route('tasks.update', $task),
                ['title' => 'Updated by member']
            )->assertOk();

            // Non-member cannot update
            $this->actingAs($nonMember)->putJson(
                route('tasks.update', $task),
                ['title' => 'Updated by non-member']
            )->assertForbidden();
        });
    });

    describe('task assignment', function () {
        test('manager_can_assign_user_to_task', function () {
            $creator = User::factory()->create(['role' => 'member']);
            $manager = User::factory()->create(['role' => 'manager']);
            $assignee = User::factory()->create(['role' => 'member']);

            $project = Project::factory()->create(['created_by' => $creator->id]);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $creator->id, 'role' => 'lead']);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $assignee->id, 'role' => 'member']);

            $task = Task::factory()->create([
                'project_id' => $project->id,
                'created_by' => $creator->id,
            ]);

            $this->actingAs($manager)->postJson(
                route('tasks.assign', $task),
                ['user_id' => $assignee->id]
            )->assertOk();

            $this->assertDatabaseHas('task_assignees', [
                'task_id' => $task->id,
                'user_id' => $assignee->id,
            ]);
        });

        test('authorized_user_can_assign_user_to_task', function () {
            $creator = User::factory()->create(['role' => 'member']);
            $member = User::factory()->create(['role' => 'member']);
            $assignee = User::factory()->create(['role' => 'member']);

            $project = Project::factory()->create(['created_by' => $creator->id]);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $creator->id, 'role' => 'lead']);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $member->id, 'role' => 'member']);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $assignee->id, 'role' => 'member']);

            $task = Task::factory()->create([
                'project_id' => $project->id,
                'created_by' => $creator->id,
            ]);

            $this->actingAs($creator)->postJson(
                route('tasks.assign', $task),
                ['user_id' => $assignee->id]
            )->assertOk();

            $this->assertDatabaseHas('task_assignees', [
                'task_id' => $task->id,
                'user_id' => $assignee->id,
            ]);
        });

        test('assigning_non_project_member_auto_adds_them_to_project', function () {
            $creator = User::factory()->create(['role' => 'member']);
            $nonMember = User::factory()->create(['role' => 'member']);

            $project = Project::factory()->create(['created_by' => $creator->id]);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $creator->id, 'role' => 'lead']);

            $task = Task::factory()->create([
                'project_id' => $project->id,
                'created_by' => $creator->id,
            ]);

            $this->actingAs($creator)->postJson(
                route('tasks.assign', $task),
                ['user_id' => $nonMember->id]
            )->assertOk();

            $this->assertDatabaseHas('task_assignees', [
                'task_id' => $task->id,
                'user_id' => $nonMember->id,
            ]);

            $this->assertDatabaseHas('project_members', [
                'project_id' => $project->id,
                'user_id' => $nonMember->id,
            ]);
        });

        test('can_unassign_user_from_task', function () {
            $creator = User::factory()->create(['role' => 'member']);
            $assignee = User::factory()->create(['role' => 'member']);

            $project = Project::factory()->create(['created_by' => $creator->id]);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $creator->id, 'role' => 'lead']);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $assignee->id, 'role' => 'member']);

            $task = Task::factory()->create([
                'project_id' => $project->id,
                'created_by' => $creator->id,
            ]);
            $task->assign($assignee);

            $this->actingAs($creator)->deleteJson(
                route('tasks.unassign', ['task' => $task, 'userId' => $assignee->id])
            )->assertOk();

            $this->assertDatabaseMissing('task_assignees', [
                'task_id' => $task->id,
                'user_id' => $assignee->id,
            ]);
        });
    });

    describe('task deletion', function () {
        test('only_creator_and_lead_can_delete_task', function () {
            $creator = User::factory()->create(['role' => 'member']);
            $lead = User::factory()->create(['role' => 'member']);
            $member = User::factory()->create(['role' => 'member']);

            $project = Project::factory()->create(['created_by' => $creator->id]);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $creator->id, 'role' => 'lead']);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $lead->id, 'role' => 'lead']);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $member->id, 'role' => 'member']);

            $task1 = Task::factory()->create([
                'project_id' => $project->id,
                'created_by' => $creator->id,
            ]);

            $task2 = Task::factory()->create([
                'project_id' => $project->id,
                'created_by' => $member->id,
            ]);

            // Creator can delete their own
            $this->actingAs($creator)->deleteJson(route('tasks.destroy', $task1))->assertOk();

            // Lead can delete any
            $this->actingAs($lead)->deleteJson(route('tasks.destroy', $task2))->assertOk();

            // Member cannot delete
            $task3 = Task::factory()->create([
                'project_id' => $project->id,
                'created_by' => $creator->id,
            ]);
            $this->actingAs($member)->deleteJson(route('tasks.destroy', $task3))->assertForbidden();
        });
    });

    describe('task visibility', function () {
        test('authenticated_users_can_view_tasks_in_internal_system', function () {
            $member = User::factory()->create(['role' => 'member']);
            $nonMember = User::factory()->create(['role' => 'member']);

            $project = Project::factory()->create(['created_by' => $member->id]);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $member->id, 'role' => 'lead']);

            $task = Task::factory()->create([
                'project_id' => $project->id,
                'created_by' => $member->id,
            ]);

            // Member can view
            $this->actingAs($member)->getJson(route('tasks.show', $task))->assertOk();

            // Non-member can also view in internal system policy
            $this->actingAs($nonMember)->getJson(route('tasks.show', $task))->assertOk();
        });

        test('admin_can_view_all_tasks', function () {
            $admin = User::factory()->create(['role' => 'admin']);
            $member = User::factory()->create(['role' => 'member']);

            $project = Project::factory()->create(['created_by' => $member->id]);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $member->id, 'role' => 'lead']);

            $task = Task::factory()->create([
                'project_id' => $project->id,
                'created_by' => $member->id,
            ]);

            // Admin can view
            $this->actingAs($admin)->getJson(route('tasks.show', $task))->assertOk();
        });
    });
});
