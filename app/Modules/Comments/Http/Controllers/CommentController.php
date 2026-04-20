<?php

namespace App\Modules\Comments\Http\Controllers;

use App\Modules\Comments\Http\Requests\StoreCommentRequest;
use App\Modules\Comments\Models\TaskComment;
use App\Modules\Projects\Services\ProjectService;
use App\Modules\Tasks\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CommentController
{
    /**
     * Create a new controller instance.
     */
    public function __construct(private ProjectService $projectService)
    {
    }

    /**
     * Get all comments for a task.
     *
     * GET /tasks/{id}/comments
     */
    public function index($task): JsonResponse
    {
        // Get the task by ID directly
        $task = Task::find($task);
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $user = Auth::user();

        // Check if user is a member of the project
        if (!$this->projectService->isMember($task->project_id, $user->id)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comments = $task->comments()
            ->with('user:id,name,email')
            ->orderBy('created_at', 'asc')
            ->paginate(20);

        return response()->json([
            'task_id' => $task->id,
            'comments_count' => $comments->total(),
            'data' => $comments->items(),
            'pagination' => [
                'current_page' => $comments->currentPage(),
                'per_page' => $comments->perPage(),
                'total' => $comments->total(),
                'last_page' => $comments->lastPage(),
            ],
        ]);
    }

    /**
     * Create a new comment on a task.
     *
     * POST /tasks/{id}/comments
     */
    public function store(StoreCommentRequest $request, $task): JsonResponse|RedirectResponse
    {
        // Get the task by ID directly
        $task = Task::find($task);
        if (!$task) {
            if (! $request->expectsJson()) {
                return back()->withErrors(['comment' => 'Task not found.']);
            }

            return response()->json(['message' => 'Task not found'], 404);
        }

        $user = Auth::user();

        if (! $user) {
            if (! $request->expectsJson()) {
                return redirect()->route('login');
            }

            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Use task view permission as fallback so valid assignees can comment.
        if (Gate::allows('view', $task)) {
            $canComment = true;
        } else {
            $canComment = $this->projectService->isMember($task->project_id, $user->id);
        }

        // Check if user is a member of the project
        if (! $canComment) {
            if (! $request->expectsJson()) {
                return back()->withErrors([
                    'comment' => 'You are not allowed to comment on this task.',
                ])->withInput();
            }

            return response()->json([
                'message' => 'You must be a member of this project to comment on tasks',
            ], 403);
        }

        $comment = TaskComment::create([
            'task_id' => $task->id,
            'user_id' => $user->id,
            'body' => $request->validated('body'),
        ]);

        if (! $request->expectsJson()) {
            return back()->with('success', 'Comment added successfully.');
        }

        return response()->json([
            'message' => 'Comment created successfully',
            'data' => $comment->load('user:id,name,email'),
        ], 201);
    }

    /**
     * Delete a comment.
     *
     * DELETE /comments/{id}
     */
    public function destroy($comment): JsonResponse|RedirectResponse
    {
        // Get the comment by ID directly
        $comment = TaskComment::find($comment);
        if (!$comment) {
            if (! request()->expectsJson()) {
                return back()->withErrors(['comment' => 'Comment not found.']);
            }

            return response()->json(['message' => 'Comment not found'], 404);
        }

        $user = Auth::user();

        if (! $user) {
            if (! request()->expectsJson()) {
                return redirect()->route('login');
            }

            return response()->json(['message' => 'Unauthorized'], 401);
        }
        
        // Check authorization manually instead of using authorize() middleware
        // Only allow the comment owner or admin to delete
        if ($user->role !== 'admin' && $comment->user_id !== $user->id) {
            if (! request()->expectsJson()) {
                return back()->withErrors(['comment' => 'Unauthorized to delete this comment']);
            }

            return response()->json(['message' => 'Unauthorized to delete this comment'], 403);
        }

        $comment->delete();

        if (! request()->expectsJson()) {
            return back()->with('success', 'Comment deleted successfully.');
        }

        return response()->json([
            'message' => 'Comment deleted successfully',
        ]);
    }
}
