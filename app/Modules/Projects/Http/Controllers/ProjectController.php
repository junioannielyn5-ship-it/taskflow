<?php

namespace App\Modules\Projects\Http\Controllers;

use App\Modules\Projects\Http\Requests\AddMemberRequest;
use App\Modules\Projects\Http\Requests\StoreProjectRequest;
use App\Modules\Projects\Http\Requests\UpdateProjectRequest;
use App\Modules\Projects\Models\Project;
use App\Modules\Projects\Models\ProjectMember;
use App\Modules\Projects\Services\ProjectService;
use App\Modules\Identity\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{
    use AuthorizesRequests;

    private const SALES_OWNER_MAP = [
        'LS' => 'Lawrence Solee',
        'NR' => 'Norman Reyes',
        'PB' => 'Philip Borromeo',
        'VA' => 'Vera Andino',
        'EC' => 'Edcel Ching',
    ];

    public function __construct(
        private ProjectService $projectService
    ) {}

    /**
     * Get all projects the authenticated user belongs to.
     */
    public function create()
    {
        if (Gate::denies('create-project')) {
            abort(403, 'Members can view and update assigned work but cannot create new projects.');
        }

        return view('projects.create');
    }

    public function index()
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (!$user) {
            abort(401, 'Unauthorized');
        }

        // Admin, PM, and Lead can see ALL projects
        if ($user->isAdmin() || $user->isPM() || $user->isLead()) {
            $role = $user->isAdmin() ? 'admin' : ($user->isPM() ? 'project_manager' : 'lead');
            $projects = Project::query()
                ->latest()
                ->get()
                ->map(function ($project) use ($role) {
                    $project->member_role = $role;
                    return $project;
                });

            if (request()->expectsJson()) {
                return response()->json([
                    'data' => $projects,
                    'count' => $projects->count(),
                ], 200);
            }

            return view('projects.index', [
                'projects' => $projects,
            ]);
        }

        // Members only see projects they are assigned to
        $projects = ProjectMember::where('user_id', $user->id)
            ->with('project')
            ->get()
            ->filter(function ($member) {
                return !is_null($member->project);
            })
            ->map(function ($member) {
                $project = $member->project;
                $project->member_role = $member->role;
                return $project;
            });

        if (request()->expectsJson()) {
            return response()->json([
                'data' => $projects,
                'count' => $projects->count(),
            ], 200);
        }

        return view('projects.index', [
            'projects' => $projects,
        ]);
    }

    /**
     * Create a new project.
     */
    public function store(StoreProjectRequest $request)
    {
        if (Gate::denies('create-project')) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Members can view and update assigned work but cannot create new projects.',
                ], 403);
            }

            return redirect()->route('projects.index')->withErrors([
                'project_permission' => 'Members can view and update assigned work but cannot create new projects.',
            ]);
        }

        $user = Auth::user();
        $validated = $request->validated();
        $ownerCode = $validated['project_owner'] ?? null;
        $projectOwner = $ownerCode ? (self::SALES_OWNER_MAP[$ownerCode] ?? null) : null;

        // Create the project
        $project = Project::create([
            'name' => $validated['name'],
            'company_name' => $validated['company_name'] ?? null,
            'project_owner' => $projectOwner,
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'] ?? 'pending_request',
            'created_by' => $user->id,
        ]);

        // Add creator as lead
        ProjectMember::create([
            'project_id' => $project->id,
            'user_id' => $user->id,
            'role' => 'lead',
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Project created successfully',
                'data' => $project->load(['creator', 'members']),
            ], 201);
        }

        return redirect()->route('projects.index')->with('success', 'Project created successfully');
    }

    /**
     * Get a specific project.
     */
    public function show(Project $project)
    {
        $this->authorize('view', $project);

        $project->load([
            'creator',
            'members.user',
            'tasks' => fn ($query) => $query->with('assignees')->latest()->take(20),
        ]);

        if (!request()->expectsJson()) {
            return view('projects.show', [
                'project' => $project,
            ]);
        }

        return response()->json([
            'data' => $project,
        ], 200);
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified project in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $this->authorize('update', $project);
        $validated = $request->validated();
        $project->update($validated);
        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    /**
     * Update a project.
     */
    public function updateProject(UpdateProjectRequest $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validated();
        if (array_key_exists('project_owner', $validated)) {
            $validated['project_owner'] = self::SALES_OWNER_MAP[$validated['project_owner']] ?? $project->project_owner;
        }

        $project->update($validated);

        return response()->json([
            'message' => 'Project updated successfully',
            'data' => $project->load(['creator', 'members']),
        ], 200);
    }

    /**
     * Delete a project.
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        $project->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'message' => 'Project deleted successfully',
            ], 200);
        }
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully');
    }

    /**
     * Add a member to a project.
     */
    public function addMember(AddMemberRequest $request, Project $project)
    {
        $this->authorize('manageMembership', $project);

        $member = $this->projectService->addMember(
            $project->id,
            $request->user_id,
            $request->role ?? 'member'
        );

        return response()->json([
            'message' => 'Member added successfully',
            'data' => $member->load('user'),
        ], 201);
    }

    /**
     * Remove a member from a project.
     */
    public function removeMember(Project $project, int $userId)
    {
        $this->authorize('manageMembership', $project);

        $this->projectService->removeMember($project->id, $userId);

        return response()->json([
            'message' => 'Member removed successfully',
        ], 200);
    }

    /**
     * Get all members of a project.
     */
    public function getMembers(Project $project)
    {
        $this->authorize('view', $project);

        $members = $this->projectService->getProjectMembers($project->id);

        return response()->json([
            'data' => $members,
            'count' => $members->count(),
        ], 200);
    }
}
