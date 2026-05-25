<?php

namespace App\Modules\Attachments\Http\Controllers;

use App\Modules\Attachments\Http\Requests\UploadAttachmentRequest;
use App\Modules\Attachments\Models\TaskAttachment;
use App\Modules\Projects\Services\ProjectService;
use App\Modules\Tasks\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AttachmentController
{
    public function __construct(private ProjectService $projectService)
    {
    }

    /**
     * Upload an attachment for a task.
     *
     * POST /tasks/{id}/attachments
     */
    public function store(UploadAttachmentRequest $request, Task $task)
    {
        $user = $request->user();

        // Membership check
        if (!$this->projectService->isMember($task->project_id, $user->id)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'You are not a member of the project'], 403);
            }

            return back()->withErrors(['file' => 'You are not a member of the project']);
        }

        /** @var UploadedFile $file */
        $file = $request->file('file');

        // Store in private disk
        $path = $file->store('attachments', ['disk' => 'private']);

        $attachment = TaskAttachment::create([
            'task_id' => $task->id,
            'user_id' => $user->id,
            'path' => $path,
            'filename' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Attachment uploaded',
                'data' => $attachment,
            ], 201);
        }

        return back()->with('success', 'Attachment uploaded.');
    }

    /**
     * Download/stream attachment securely.
     *
     * GET /attachments/{id}/download
     */
    public function download(Request $request, TaskAttachment $attachment)
    {
        $user = $request->user();

        $canDownload = $this->projectService->isMember($attachment->task->project_id, $user->id)
            || $user->isAdmin()
            || $user->isPM()
            || $user->isLead();

        if (!$canDownload) {
            return response()->json(['message' => 'You are not a member of the project'], 403);
        }

        return response()->download(
            Storage::disk('private')->path($attachment->path),
            $attachment->filename
        );
    }

    /**
     * View attachment inline securely.
     *
     * GET /attachments/{id}/view
     */
    public function view(Request $request, TaskAttachment $attachment)
    {
        $user = $request->user();

        $canView = $this->projectService->isMember($attachment->task->project_id, $user->id)
            || $user->isAdmin()
            || $user->isPM()
            || $user->isLead();

        if (!$canView) {
            return response()->json(['message' => 'You are not a member of the project'], 403);
        }

        return response()->file(Storage::disk('private')->path($attachment->path));
    }

    /**
     * Delete an attachment (record + file).
     *
     * DELETE /attachments/{id}
     */
    public function destroy(Request $request, TaskAttachment $attachment)
    {
        $user = $request->user();

        // Only owner or admin can delete
        if ($user->role !== 'admin' && $attachment->user_id !== $user->id) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            return back()->withErrors(['file' => 'Unauthorized']);
        }

        $attachment->delete();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Attachment deleted']);
        }

        return back()->with('success', 'Attachment deleted.');
    }
}
    


