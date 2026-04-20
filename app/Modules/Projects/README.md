# Projects & Membership Module

The Projects module manages project creation, organization, and membership. It acts as the gatekeeper for all project-specific data and integrates with the Identity module for authorization.

## Module Structure

```
app/Modules/Projects/
├── Http/
│   ├── Controllers/
│   │   └── ProjectController.php    # CRUD and membership endpoints
│   └── Requests/
│       ├── StoreProjectRequest.php  # Create validation
│       ├── UpdateProjectRequest.php # Update validation
│       └── AddMemberRequest.php     # Membership validation
├── Models/
│   ├── Project.php                  # Project model
│   └── ProjectMember.php            # Project membership model
├── Policies/
│   └── ProjectPolicy.php            # Authorization checks
├── Services/
│   └── ProjectService.php           # Business logic
├── Providers/
│   └── ProjectServiceProvider.php   # Module provider
└── Routes/
    └── api.php                      # API routes
```

## Key Concepts

### Project Roles
Projects have their own role system, separate from global IAM roles:
- **lead**: Can manage project members and update project details
- **member**: Can view project and access project data

### Project Creator
When a project is created, the creator automatically becomes a **lead** member.

### Authorization Rules
1. **Create Project**: Only users with `admin` or `pm` global role
2. **View Project**: Creator, admin, or project members only
3. **Update Project**: Creator, admin, or project leads only
4. **Delete Project**: Creator or admin only
5. **Manage Membership**: Creator, admin, or project leads only

## Models

### Project

Fields:
- `id` - Primary key
- `name` - Project name (required, max 255 chars)
- `description` - Project description (optional, max 1000 chars)
- `status` - Active or archived (default: active)
- `created_by` - Foreign key to User who created it
- `created_at`, `updated_at` - Timestamps

Methods:
- `creator()` - Get the user who created the project
- `members()` - Get all project members
- `users()` - Get users with pivot role data
- `hasMember(User $user)` - Check if user is member
- `isLead(User $user)` - Check if user is lead
- `getUserRole(User $user)` - Get user's role in project
- `canManageMembership(User $user)` - Check if user can manage members

### ProjectMember

Fields:
- `id` - Primary key
- `project_id` - Foreign key to Project
- `user_id` - Foreign key to User
- `role` - member or lead
- `created_at`, `updated_at` - Timestamps
- **Unique constraint**: (project_id, user_id)

Methods:
- `project()` - Get associated project
- `user()` - Get associated user
- `isLead()` - Check if role is lead
- `isMember()` - Check if role is member

## API Endpoints

### List Projects

```
GET /api/projects
Authorization: Bearer {token}

Response (200):
{
    "data": [
        {
            "id": 1,
            "name": "Project Name",
            "description": "Description",
            "status": "active",
            "created_by": 1,
            "member_role": "lead"
        }
    ],
    "count": 1
}
```

### Create Project

```
POST /api/projects
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "New Project",
    "description": "Optional description",
    "status": "active"
}

Response (201):
{
    "message": "Project created successfully",
    "data": {
        "id": 1,
        "name": "New Project",
        "description": "Optional description",
        "status": "active",
        "created_by": 1,
        "creator": { ... },
        "members": [ ... ]
    }
}
```

### Get Project Details

```
GET /api/projects/{id}
Authorization: Bearer {token}

Response (200):
{
    "data": {
        "id": 1,
        "name": "Project Name",
        "description": "Description",
        "status": "active",
        "created_by": 1,
        "creator": { ... },
        "members": [ ... ]
    }
}
```

### Update Project

```
PATCH /api/projects/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "Updated Name",
    "description": "Updated description",
    "status": "archived"
}

Response (200):
{
    "message": "Project updated successfully",
    "data": { ... }
}
```

### Delete Project

```
DELETE /api/projects/{id}
Authorization: Bearer {token}

Response (200):
{
    "message": "Project deleted successfully"
}
```

### Add Project Member

```
POST /api/projects/{id}/members
Authorization: Bearer {token}
Content-Type: application/json

{
    "user_id": 5,
    "role": "member"
}

Response (201):
{
    "message": "Member added successfully",
    "data": {
        "id": 1,
        "project_id": 1,
        "user_id": 5,
        "role": "member",
        "user": { ... }
    }
}
```

### Remove Project Member

```
DELETE /api/projects/{id}/members/{userId}
Authorization: Bearer {token}

Response (200):
{
    "message": "Member removed successfully"
}
```

### Get Project Members

```
GET /api/projects/{id}/members
Authorization: Bearer {token}

Response (200):
{
    "data": [
        {
            "id": 1,
            "project_id": 1,
            "user_id": 1,
            "role": "lead",
            "user": { ... }
        }
    ],
    "count": 1
}
```

## Service Layer

### ProjectService

Used by other modules to interact with projects:

```php
use App\Modules\Projects\Services\ProjectService;

class MyService {
    public function __construct(
        private ProjectService $projectService
    ) {}

    public function checkAccess($projectId, $userId) {
        // Check if user is member
        if (!$this->projectService->isMember($projectId, $userId)) {
            throw new AuthorizationException();
        }

        // Check if user is lead
        if ($this->projectService->isLead($projectId, $userId)) {
            // Lead-only logic
        }

        // Get user's role
        $role = $this->projectService->getUserRole($projectId, $userId);
    }
}
```

Available methods:
- `isMember(int $projectId, int $userId): bool`
- `isLead(int $projectId, int $userId): bool`
- `getUserRole(int $projectId, int $userId): ?string`
- `getUserProjects(int $userId)` - Get all projects user belongs to
- `addMember(int $projectId, int $userId, string $role): ProjectMember`
- `removeMember(int $projectId, int $userId): bool`
- `updateMemberRole(int $projectId, int $userId, string $role): ProjectMember`
- `canManageMembership(int $projectId, int $userId): bool`
- `getProjectMembers(int $projectId)`

## Policy Authorization

```php
// In controllers
$this->authorize('view', $project);      // Check if can view
$this->authorize('update', $project);    // Check if can update
$this->authorize('delete', $project);    // Check if can delete
$this->authorize('manageMembership', $project); // Check if can manage members
```

## Database Integration

### Projects Table
```sql
CREATE TABLE projects (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description VARCHAR(1000),
    status VARCHAR(255) DEFAULT 'active',
    created_by BIGINT NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id),
    INDEX (status),
    INDEX (created_by)
);
```

### Project Members Table
```sql
CREATE TABLE project_members (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    project_id BIGINT NOT NULL,
    user_id BIGINT NOT NULL,
    role VARCHAR(255) DEFAULT 'member',
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    UNIQUE KEY (project_id, user_id),
    FOREIGN KEY (project_id) REFERENCES projects(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    INDEX (user_id),
    INDEX (role)
);
```

## Testing

Run all project tests:
```bash
php artisan test tests/Feature/Projects/
```

Run specific test:
```bash
php artisan test tests/Feature/Projects/ProjectTest.php::test_only_authorized_roles_can_create_projects
```

Test coverage includes:
- Authorization and role checking
- CRUD operations
- Membership management
- Visibility and privacy
- Integration with Identity module

## Cross-Module Usage

### From Other Modules

```php
use App\Modules\Projects\Services\ProjectService;
use App\Modules\Projects\Models\Project;

// In task module, verify user has access to project
$projectService = app(ProjectService::class);

if (!$projectService->isMember($projectId, auth()->id())) {
    throw new AuthorizationException('Not a member of this project');
}

// In task policies
public function create(User $user, Project $project) {
    return $projectService->isMember($project->id, $user->id);
}
```

## Integration with Identity Module

- Uses `App\Modules\Identity\Models\User` for user references
- Checks global roles (`admin`, `pm`) for project creation
- Respects global admin status for all operations
- Separate from global role system (project roles are independent)

## Important Notes

- Project roles (lead, member) are **separate** from global IAM roles
- Creator is automatically added as **lead**
- Only `admin` and `pm` global roles can create projects
- Project leads can manage members
- Non-members cannot access project data
- Unique constraint prevents duplicate memberships
- Cascading deletes when project is deleted

## Common Patterns

### Check if User Can Manage Team in Project

```php
$project = Project::find($projectId);
if ($project->canManageMembership($user)) {
    // Allow manage operations
}
```

### Get All Projects for Dashboard

```php
$projects = ProjectMember::where('user_id', $userId)
    ->with('project')
    ->get()
    ->map->project;
```

### Add Multiple Members

```php
$projectService = app(ProjectService::class);

foreach ($userIds as $userId) {
    $projectService->addMember($projectId, $userId, 'member');
}
```

## Migration Notes

Migrations created:
- `2025_08_16_000000_create_projects_table.php`
- `2025_08_16_000001_create_project_members_table.php`

Run with:
```bash
php artisan migrate
```
