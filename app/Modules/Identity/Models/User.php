<?php

namespace App\Modules\Identity\Models;

use App\Modules\Projects\Models\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    private const ROLE_ALIASES = [
        'pm' => 'project_manager',
        'employee' => 'member',
        'team_lead' => 'lead',
        'teamlead' => 'lead',
    ];

    private const ROLE_PRIORITY = [
        'admin',
        'manager',
        'project_manager',
        'executive',
        'lead',
        'member',
    ];

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_members', 'user_id', 'project_id')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(\App\Models\Message::class);
    }

    public function roles()
    {
        return $this->belongsToMany(\App\Models\Role::class, 'role_user', 'user_id', 'role_id');
    }
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
        ];
    }

    /**
     * Check if user is an admin.
     */
    public function isAdmin(): bool
    {
        return in_array('admin', $this->resolvedRoles(), true);
    }

    /**
     * Check if user is a project manager.
     */
    public function isPM(): bool
    {
        return collect($this->resolvedRoles())
            ->intersect(['project_manager', 'pm', 'manager'])
            ->isNotEmpty();
    }

    /**
     * Check if user is a team lead.
     */
    public function isLead(): bool
    {
        return in_array('lead', $this->resolvedRoles(), true);
    }

    /**
     * Check if user is a member.
     */
    public function isMember(): bool
    {
        return in_array('member', $this->resolvedRoles(), true);
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole(string $role): bool
    {
        $resolvedRoles = $this->resolvedRoles();

        return match ($role) {
            'project_manager', 'pm' => in_array('project_manager', $resolvedRoles, true),
            'manager' => in_array('manager', $resolvedRoles, true),
            default => in_array($role, $resolvedRoles, true),
        };
    }

    /**
     * Check if user has any of the given roles.
     */
    public function hasAnyRole(array $roles): bool
    {
        return collect($this->resolvedRoles())
            ->intersect($roles)
            ->isNotEmpty();
    }

    public function effectiveRole(): string
    {
        $resolvedRoles = $this->resolvedRoles();

        foreach (self::ROLE_PRIORITY as $role) {
            if (in_array($role, $resolvedRoles, true)) {
                return $role;
            }
        }

        return $resolvedRoles[0] ?? 'member';
    }

    public function roleLabel(): string
    {
        $role = $this->effectiveRole();

        return match ($role) {
            'project_manager', 'pm', 'manager' => 'Project Manager',
            'lead', 'team_lead', 'teamlead' => 'Team Lead',
            'member', 'employee' => 'Member',
            default => str($role)->replace('_', ' ')->title()->toString(),
        };
    }

    private function resolvedRoles(): array
    {
        $baseRole = trim((string) $this->role);

        $relationRoles = $this->roles
            ? $this->roles->pluck('name')->all()
            : $this->roles()->pluck('name')->all();

        return collect([$baseRole])
            ->merge($relationRoles)
            ->map(fn ($role) => trim((string) $role))
            ->filter()
            ->map(fn ($role) => self::ROLE_ALIASES[$role] ?? $role)
            ->unique()
            ->values()
            ->all();
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return \Database\Factories\UserFactory::new();
    }
}
