<?php

use App\Modules\Comments\Events\CommentCreated;
use App\Modules\Comments\Models\TaskComment;
use App\Modules\Identity\Models\User;
use App\Modules\Projects\Models\Project;
use App\Modules\Projects\Models\ProjectMember;
use App\Modules\Tasks\Models\Task;
use Illuminate\Support\Facades\Event;

describe('Comments Module', function () {
    beforeEach(function () {
        $this->lead = User::factory()->create(['role' => 'lead']);
        $this->member = User::factory()->create(['role' => 'member']);
        $this->otherUser = User::factory()->create(['role' => 'member']);
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->project = Project::factory()->create(['created_by' => $this->lead->id]);
        ProjectMember::create(['project_id' => $this->project->id, 'user_id' => $this->lead->id, 'role' => 'lead']);
        ProjectMember::create(['project_id' => $this->project->id, 'user_id' => $this->member->id, 'role' => 'member']);
    });

    describe('Comment Creation', function () {
        test('authorized_project_member_can_comment_on_task', function () {
            $task = Task::factory()->create([
                'project_id' => $this->project->id,
                'created_by' => $this->lead->id,
                'status' => 'todo',
                'title' => 'Test Task',
                'priority' => 'medium',
            ]);

            $this->actingAs($this->member)->postJson(
                route('comments.store', $task),
                ['body' => 'This is a test comment']
            )->assertCreated()
             ->assertJsonStructure(['message', 'data' => ['id', 'body', 'user']]);

            $this->assertDatabaseHas('task_comments', [
                'task_id' => $task->id,
                'user_id' => $this->member->id,
                'body' => 'This is a test comment',
            ]);
        });

        test('authenticated_non_member_can_comment_on_task_in_internal_system', function () {
            $task = Task::factory()->create([
                'project_id' => $this->project->id,
                'created_by' => $this->lead->id,
                'status' => 'todo',
                'title' => 'Test Task',
                'priority' => 'medium',
            ]);

            $this->actingAs($this->otherUser)->postJson(
                route('comments.store', $task),
                ['body' => 'This is a test comment']
            )->assertCreated();

            $this->assertDatabaseHas('task_comments', [
                'task_id' => $task->id,
                'user_id' => $this->otherUser->id,
                'body' => 'This is a test comment',
            ]);
        });

        test('comment_requires_body', function () {
            $task = Task::factory()->create([
                'project_id' => $this->project->id,
                'created_by' => $this->lead->id,
                'status' => 'todo',
                'title' => 'Test Task',
                'priority' => 'medium',
            ]);

            $this->actingAs($this->member)->postJson(
                route('comments.store', $task),
                ['body' => '']
            )->assertUnprocessable()
             ->assertJsonValidationErrors('body');
        });

        test('comment_body_cannot_exceed_5000_characters', function () {
            $task = Task::factory()->create([
                'project_id' => $this->project->id,
                'created_by' => $this->lead->id,
                'status' => 'todo',
                'title' => 'Test Task',
                'priority' => 'medium',
            ]);

            $longBody = str_repeat('a', 5001);

            $this->actingAs($this->member)->postJson(
                route('comments.store', $task),
                ['body' => $longBody]
            )->assertUnprocessable()
             ->assertJsonValidationErrors('body');
        });

        test('unauthenticated_user_cannot_comment', function () {
            $task = Task::factory()->create([
                'project_id' => $this->project->id,
                'created_by' => $this->lead->id,
                'status' => 'todo',
                'title' => 'Test Task',
                'priority' => 'medium',
            ]);

            $this->postJson(
                route('comments.store', $task),
                ['body' => 'This is a test comment']
            )->assertUnauthorized();
        });
    });

    describe('Comment Events', function () {
        test('comment_created_event_is_dispatched', function () {
            $task = Task::factory()->create([
                'project_id' => $this->project->id,
                'created_by' => $this->lead->id,
                'status' => 'todo',
                'title' => 'Test Task',
                'priority' => 'medium',
            ]);

            Event::fake(CommentCreated::class);

            $this->actingAs($this->member)->postJson(
                route('comments.store', $task),
                ['body' => 'Test comment']
            );

            Event::assertDispatched(CommentCreated::class);
        });

        test('mentioned_project_member_receives_notification', function () {
            $task = Task::factory()->create([
                'project_id' => $this->project->id,
                'created_by' => $this->lead->id,
                'status' => 'todo',
                'title' => 'Test Task',
                'priority' => 'medium',
            ]);

            ProjectMember::create([
                'project_id' => $this->project->id,
                'user_id' => $this->otherUser->id,
                'role' => 'member',
            ]);

            $mentionToken = str($this->otherUser->name)->lower()->replaceMatches('/[^a-z0-9]+/', '_')->trim('_')->toString();

            $this->actingAs($this->member)->postJson(
                route('comments.store', $task),
                ['body' => "Please check this @{$mentionToken}"]
            )->assertCreated();

            $this->assertDatabaseHas('notifications', [
                'notifiable_id' => $this->otherUser->id,
                'type' => \App\Modules\Notifications\Notifications\NewCommentNotification::class,
            ]);
        });
    });

    describe('Comment Deletion', function () {
        test('user_can_delete_own_comment', function () {
            $task = Task::factory()->create([
                'project_id' => $this->project->id,
                'created_by' => $this->lead->id,
                'status' => 'todo',
                'title' => 'Test Task',
                'priority' => 'medium',
            ]);

            $comment = TaskComment::factory()->create([
                'task_id' => $task->id,
                'user_id' => $this->member->id,
            ]);

            $this->actingAs($this->member)->deleteJson(
                route('comments.destroy', $comment)
            )->assertOk();

            $this->assertDatabaseMissing('task_comments', [
                'id' => $comment->id,
            ]);
        });

        test('user_cannot_delete_another_users_comment', function () {
            $task = Task::factory()->create([
                'project_id' => $this->project->id,
                'created_by' => $this->lead->id,
                'status' => 'todo',
                'title' => 'Test Task',
                'priority' => 'medium',
            ]);

            $comment = TaskComment::factory()->create([
                'task_id' => $task->id,
                'user_id' => $this->member->id,
            ]);

            $this->actingAs($this->otherUser)->deleteJson(
                route('comments.destroy', $comment)
            )->assertForbidden();

            $this->assertDatabaseHas('task_comments', [
                'id' => $comment->id,
            ]);
        });

        test('admin_can_delete_any_comment', function () {
            $task = Task::factory()->create([
                'project_id' => $this->project->id,
                'created_by' => $this->lead->id,
                'status' => 'todo',
                'title' => 'Test Task',
                'priority' => 'medium',
            ]);

            $comment = TaskComment::factory()->create([
                'task_id' => $task->id,
                'user_id' => $this->member->id,
            ]);

            $this->actingAs($this->admin)->deleteJson(
                route('comments.destroy', $comment)
            )->assertOk();

            $this->assertDatabaseMissing('task_comments', [
                'id' => $comment->id,
            ]);
        });

        test('unauthenticated_user_cannot_delete_comment', function () {
            $comment = TaskComment::factory()->create();

            $this->deleteJson(
                route('comments.destroy', $comment)
            )->assertUnauthorized();
        });
    });

    describe('Comment Retrieval', function () {
        test('can_list_comments_on_task', function () {
            $task = Task::factory()->create([
                'project_id' => $this->project->id,
                'created_by' => $this->lead->id,
                'status' => 'todo',
                'title' => 'Test Task',
                'priority' => 'medium',
            ]);

            TaskComment::factory(3)->create([
                'task_id' => $task->id,
            ]);

            $this->actingAs($this->member)->getJson(
                route('comments.index', $task)
            )->assertOk()
             ->assertJsonStructure(['task_id', 'comments_count', 'data', 'pagination']);
        });

        test('comments_are_ordered_by_created_at', function () {
            $task = Task::factory()->create([
                'project_id' => $this->project->id,
                'created_by' => $this->lead->id,
                'status' => 'todo',
                'title' => 'Test Task',
                'priority' => 'medium',
            ]);

            $comment1 = TaskComment::factory()->create([
                'task_id' => $task->id,
                'body' => 'First',
            ]);
            sleep(1);
            $comment2 = TaskComment::factory()->create([
                'task_id' => $task->id,
                'body' => 'Second',
            ]);

            $response = $this->actingAs($this->member)->getJson(
                route('comments.index', ['task' => $task->id])
            );

            $comments = $response->json('data');
            expect($comments[0]['body'])->toEqual('First');
            expect($comments[1]['body'])->toEqual('Second');
        });

        test('non_member_cannot_list_comments', function () {
            $task = Task::factory()->create([
                'project_id' => $this->project->id,
                'created_by' => $this->lead->id,
                'status' => 'todo',
                'title' => 'Test Task',
                'priority' => 'medium',
            ]);

            TaskComment::factory(3)->create([
                'task_id' => $task->id,
            ]);

            $this->actingAs($this->otherUser)->getJson(
                route('comments.index', $task)
            )->assertForbidden();
        });

        test('unauthenticated_user_cannot_list_comments', function () {
            $task = Task::factory()->create([
                'project_id' => $this->project->id,
                'created_by' => $this->lead->id,
                'status' => 'todo',
                'title' => 'Test Task',
                'priority' => 'medium',
            ]);

            $this->getJson(
                route('comments.index', $task)
            )->assertUnauthorized();
        });

        test('pagination_works_correctly', function () {
            $task = Task::factory()->create([
                'project_id' => $this->project->id,
                'created_by' => $this->lead->id,
                'status' => 'todo',
                'title' => 'Test Task',
                'priority' => 'medium',
            ]);

            TaskComment::factory(25)->create([
                'task_id' => $task->id,
            ]);

            $response = $this->actingAs($this->member)->getJson(
                route('comments.index', $task)
            );

            expect($response->json('pagination.per_page'))->toBe(20);
            expect($response->json('pagination.total'))->toBe(25);
            expect($response->json('pagination.last_page'))->toBe(2);
        });
    });
});
