<?php

declare(strict_types=1);

use App\Modules\Attachments\Models\TaskAttachment;
use App\Modules\Projects\Models\Project;
use App\Modules\Projects\Models\ProjectMember;
use App\Modules\Tasks\Models\Task;
use App\Modules\Identity\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

describe('Attachment Module', function () {
    beforeEach(function () {
        Storage::fake('private');
        $this->user = User::factory()->create();
        $this->project = Project::factory()->create(['created_by' => $this->user->id]);
        ProjectMember::create(['project_id' => $this->project->id, 'user_id' => $this->user->id, 'role' => 'member']);
        $this->task = Task::factory()->create(['project_id' => $this->project->id, 'created_by' => $this->user->id]);
    });

    test('user cannot download attachment from unauthorized project', function () {
        $otherUser = User::factory()->create();
        $attachment = TaskAttachment::factory()->create([
            'task_id' => $this->task->id,
            'user_id' => $this->user->id,
            'path' => 'attachments/test.pdf',
            'filename' => 'test.pdf',
            'mime_type' => 'application/pdf',
            'size' => 1234,
        ]);
        $this->actingAs($otherUser);
        $response = $this->getJson("/attachments/{$attachment->id}/download");
        $response->assertStatus(403);
    });

    test('admin, pm, and lead can download member attachment', function () {
        $member = User::factory()->create(['role' => 'member']);
        ProjectMember::create([
            'project_id' => $this->project->id,
            'user_id' => $member->id,
            'role' => 'member',
        ]);

        $attachment = TaskAttachment::factory()->create([
            'task_id' => $this->task->id,
            'user_id' => $member->id,
            'path' => 'attachments/member-file.pdf',
            'filename' => 'member-file.pdf',
            'mime_type' => 'application/pdf',
            'size' => 1234,
        ]);
        Storage::disk('private')->put($attachment->path, 'dummy content');

        $admin = User::factory()->create(['role' => 'admin']);
        $pm = User::factory()->create(['role' => 'pm']);
        $lead = User::factory()->create(['role' => 'lead']);

        $this->actingAs($admin)
            ->get("/attachments/{$attachment->id}/download")
            ->assertOk();

        $this->actingAs($pm)
            ->get("/attachments/{$attachment->id}/download")
            ->assertOk();

        $this->actingAs($lead)
            ->get("/attachments/{$attachment->id}/download")
            ->assertOk();
    });

    test('file is stored in private disk not public', function () {
        $this->actingAs($this->user);
        $file = UploadedFile::fake()->create('test.pdf', 100, 'application/pdf');
        $response = $this->postJson("/tasks/{$this->task->id}/attachments", [
            'file' => $file,
        ]);
        $response->assertStatus(201);
        $attachment = TaskAttachment::first();
        Storage::disk('private')->assertExists($attachment->path);
        Storage::disk('public')->assertMissing($attachment->path);
    });

    test('attachment record and file are deleted together', function () {
        $this->actingAs($this->user);
        $file = UploadedFile::fake()->create('delete.pdf', 100, 'application/pdf');
        $response = $this->postJson("/tasks/{$this->task->id}/attachments", [
            'file' => $file,
        ]);
        $attachment = TaskAttachment::first();
        Storage::disk('private')->assertExists($attachment->path);
        $this->deleteJson("/attachments/{$attachment->id}")->assertStatus(200);
        Storage::disk('private')->assertMissing($attachment->path);
        $this->assertDatabaseMissing('task_attachments', ['id' => $attachment->id]);
    });
});
