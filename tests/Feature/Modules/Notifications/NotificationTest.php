<?php

declare(strict_types=1);

use App\Modules\Comments\Models\TaskComment;
use App\Modules\Identity\Models\User;
use App\Modules\Projects\Models\Project;
use App\Modules\Projects\Models\ProjectMember;
use App\Modules\Tasks\Models\Task;
use App\Modules\Comments\Events\CommentCreated;
use App\Modules\Notifications\Notifications\NewCommentNotification;

describe('Notifications Module', function () {
    beforeEach(function () {
        $this->user = User::factory()->create();
        $this->project = Project::factory()->create(['created_by' => $this->user->id]);
        ProjectMember::create(['project_id' => $this->project->id, 'user_id' => $this->user->id, 'role' => 'member']);
        $this->task = Task::factory()->create(['project_id' => $this->project->id, 'created_by' => $this->user->id]);
    });

    test('notification is created in db when comment is posted', function () {
        $assignee = User::factory()->create();
        ProjectMember::create(['project_id' => $this->project->id, 'user_id' => $assignee->id, 'role' => 'member']);
        $this->task->assign($assignee);

        $this->actingAs($this->user);
        $comment = TaskComment::factory()->create([
            'task_id' => $this->task->id,
            'user_id' => $this->user->id,
            'body' => 'Test comment',
        ]);

        event(new CommentCreated($comment));

        $this->assertDatabaseHas('notifications', [
            'notifiable_id' => $assignee->id,
            'type' => NewCommentNotification::class,
        ]);
    });

    test('user can fetch their own notifications', function () {
        $this->actingAs($this->user);

        $comment = TaskComment::factory()->create([
            'task_id' => $this->task->id,
            'user_id' => $this->user->id,
            'body' => 'Notification seed comment',
        ]);

        $this->user->notify(new NewCommentNotification($this->task, $comment));

        $response = $this->getJson('/notifications');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
        $this->assertCount(1, $response->json('data'));
    });

    test('user can mark notification as read', function () {
        $this->actingAs($this->user);

        $comment = TaskComment::factory()->create([
            'task_id' => $this->task->id,
            'user_id' => $this->user->id,
            'body' => 'Read notification comment',
        ]);

        $this->user->notify(new NewCommentNotification($this->task, $comment));
        $notification = $this->user->notifications()->latest()->firstOrFail();

        $this->postJson("/notifications/{$notification->id}/read")->assertStatus(200);
        $this->assertNotNull($notification->fresh()->read_at);
    });
});
