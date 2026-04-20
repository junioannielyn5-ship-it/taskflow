# Identity & Access Module

The Identity module handles authentication, authorization, and role-based access control (RBAC) for the application following the Modular Monolith architecture.

## Module Structure

```
app/Modules/Identity/
├── Http/
│   ├── Controllers/
│   │   └── AuthController.php          # Login/Logout endpoints
│   └── Requests/
│       └── LoginRequest.php            # Login validation rules
├── Models/
│   └── User.php                        # User model with role methods
├── Middleware/
│   └── RoleMiddleware.php              # Role-based route protection
├── Services/
│   └── IdentityService.php             # Service for permission checks
├── Policies/                           # (For future policy-based authorization)
├── Providers/
│   └── IdentityServiceProvider.php     # Module service provider
└── Routes/
    └── api.php                         # API routes
```

## Roles

The system supports four roles (stored as a string in the `users` table):
- **admin**: Full system access
- **pm**: Project Manager - manages projects and team
- **lead**: Team Lead - manages team members
- **member**: Team Member - regular user with limited access

## Features

### 1. User Model (`Models/User.php`)
- Extends `Illuminate\Foundation\Auth\User`
- Includes role checking methods:
  - `isAdmin()`: Check if user is admin
  - `isPM()`: Check if user is project manager
  - `isLead()`: Check if user is team lead
  - `isMember()`: Check if user is regular member
  - `hasRole(string $role)`: Check specific role
  - `hasAnyRole(array $roles)`: Check if user has any of given roles

### 2. Authentication (`Http/Controllers/AuthController.php`)
- **POST /auth/login**: Authenticate user with email and password
- **POST /auth/logout**: Logout authenticated user

### 3. Role-Based Access Control (`Middleware/RoleMiddleware.php`)
- Protects routes based on user roles
- Usage: `Route::middleware('role:admin')` or `Route::middleware('role:admin,pm')`
- Returns 401 if not authenticated, 403 if role doesn't match

### 4. Identity Service (`Services/IdentityService.php`)
Service for other modules to check permissions:
```php
$identityService = app(IdentityService::class);

if ($identityService->isAdmin($user)) {
    // Admin logic
}

if ($identityService->hasAnyRole($user, ['admin', 'pm'])) {
    // Admin or PM logic
}
```

## Usage Examples

### In Routes
```php
// Public route
Route::post('/auth/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    
    // Admin only
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
    });
});
```

### In Controllers
```php
use App\Modules\Identity\Models\User;

$user = auth()->user(); // Gets User from Identity module

if ($user->isAdmin()) {
    // Admin actions
}

if ($user->hasAnyRole(['admin', 'pm'])) {
    // Admin or PM actions
}
```

### In Services (Other Modules)
```php
use App\Modules\Identity\Services\IdentityService;

class ProjectService
{
    public function __construct(
        private IdentityService $identityService
    ) {}

    public function deleteProject(Project $project)
    {
        $user = $this->identityService->getAuthenticatedUser();
        
        if (!$this->identityService->isAdmin($user)) {
            throw new AuthorizationException();
        }
        
        // Delete project
    }
}
```

## API Endpoints

### Login
```
POST /api/auth/login
Content-Type: application/json

{
    "email": "user@example.com",
    "password": "password123"
}

Response (200):
{
    "message": "Login successful",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "user@example.com",
        "role": "admin"
    }
}
```

### Logout
```
POST /api/auth/logout
Authorization: Bearer {token}
Accept: application/json

Response (200):
{
    "message": "Logout successful"
}
```

## Database

### Users Table
The users table includes a `role` column:
```php
$table->string('role')->default('member');
```

Valid values: `admin`, `pm`, `lead`, `member`

Migration: `database/migrations/2025_08_15_000000_add_role_to_users_table.php`

## Testing

Run feature tests:
```bash
php artisan test tests/Feature/Identity/AuthTest.php
```

Test cases included:
- `test_user_can_login_with_valid_credentials`
- `test_unauthorized_user_is_blocked_from_admin_routes`
- `test_admin_user_can_access_admin_routes`
- And many more...

## Important Notes

- ⚠️ Do NOT put project-level membership logic here. That belongs to the Projects module.
- The User model is moved from `App\Models\User` to `App\Modules\Identity\Models\User`
- Other modules should use `IdentityService` for permission checks, not direct model access
- Role modifications should only be done by admins (implement in permission logic)

## Related Modules

- **Projects Module**: Handles project membership and project-specific permissions
- **Teams Module**: Handles team membership (future)
