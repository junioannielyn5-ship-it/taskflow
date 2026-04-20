<?php

namespace App\Modules\Tasks\Models;

use App\Modules\Identity\Models\User;
use App\Modules\Attachments\Models\TaskAttachment;
use App\Modules\Projects\Models\Project;
use App\Modules\Tasks\Events\TaskStatusChanged;
use App\Modules\Tasks\Events\TaskUpdated;
use App\Modules\Tasks\Models\TaskChecklistItem;
use App\Concerns\LogsAuditTrail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory, SoftDeletes, LogsAuditTrail;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'task_no',
        'project_id',
        'title',
        'description',
        'task_process',
        'specific_process',
        'sla_days',
        'company',
        'team_in_charge',
        'team',
        'deliverables',
        'document_link',
        'remarks',
        'priority',
        'date_received',
        'date_started',
        'due_date',
        'done_at',
        'blocked_by_task_id',
        'status',
        'blocked_reason',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date_received' => 'date',
            'date_started' => 'date',
            'due_date' => 'date',
            'done_at' => 'datetime',
            'sla_days' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * The "booting" method of the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::updated(function (self $task) {
            // Use Eloquent's dirty tracking to avoid false positives from cast formatting.
            $rawChanges = $task->getChanges();
            $changes = [];

            foreach ($rawChanges as $key => $newValue) {
                if (in_array($key, ['id', 'created_at', 'updated_at'], true)) {
                    continue;
                }

                $changes[$key] = [
                    'old' => $task->getOriginal($key),
                    'new' => $newValue,
                ];
            }

            // Dispatch status change event
            if (isset($changes['status'])) {
                TaskStatusChanged::dispatch($task, $changes['status']['old'], $changes['status']['new']);
            }

            // Dispatch general update event
            if (!empty($changes)) {
                TaskUpdated::dispatch($task, $changes);
            }
        });
    }

    /**
     * Get the project this task belongs to.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user who created this task.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all assignees for this task.
     */
    public function assignees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'task_assignees', 'task_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * Get all assignee records.
     */
    public function taskAssignees(): HasMany
    {
        return $this->hasMany(TaskAssignee::class);
    }

    /**
     * Check if user is assigned to this task.
     */
    public function isAssignedTo(User $user): bool
    {
        return $this->assignees()->where('user_id', $user->id)->exists();
    }

    /**
     * Assign a user to this task.
     */
    public function assign(User $user): TaskAssignee
    {
        return TaskAssignee::updateOrCreate(
            ['task_id' => $this->id, 'user_id' => $user->id],
            []
        );
    }

    /**
     * Unassign a user from this task.
     */
    public function unassign(User $user): bool
    {
        return $this->assignees()->detach($user->id) > 0;
    }

    /**
     * Get a human-readable priority label.
     */
    public function getPriorityLabel(): string
    {
        return match ($this->priority) {
            'low' => '🟢 Low',
            'medium' => '🟡 Medium',
            'high' => '🔴 High',
            'urgent' => '🚨 Urgent',
            default => $this->priority,
        };
    }

    /**
     * Human-readable label for audit logs.
     */
    public function getAuditLabel(): string
    {
        return $this->task_no ?: sprintf('TSK-%05d', $this->id);
    }

    /**
     * Check if task is overdue.
     */
    public function isOverdue(): bool
    {
        if (is_null($this->due_date)) {
            return false;
        }

        return $this->due_date->isPast() && $this->status !== 'done';
    }

    /**
     * Check if task is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'done';
    }

    /**
     * Get all activity logs for this task.
     */
    public function activityLogs(): HasMany
    {
        return $this->hasMany(\App\Modules\Workflow\Models\TaskActivityLog::class);
    }

    /**
     * Get all comments for this task.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(\App\Modules\Comments\Models\TaskComment::class);
    }

    /**
     * Get latest comment for quick list preview.
     */
    public function latestComment(): HasOne
    {
        return $this->hasOne(\App\Modules\Comments\Models\TaskComment::class)->latestOfMany();
    }

    /**
     * Get all attachments for this task.
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(TaskAttachment::class);
    }

    /**
     * Get all time logs for this task.
     */
    public function timeLogs(): HasMany
    {
        return $this->hasMany(TaskTimeLog::class);
    }

    /**
     * Get checklist items for this task.
     */
    public function checklistItems(): HasMany
    {
        return $this->hasMany(TaskChecklistItem::class)->orderBy('is_completed')->orderBy('created_at');
    }

    /**
     * Task that blocks this task.
     */
    public function blockedByTask(): BelongsTo
    {
        return $this->belongsTo(self::class, 'blocked_by_task_id');
    }

    /**
     * Tasks blocked by this task.
     */
    public function dependentTasks(): HasMany
    {
        return $this->hasMany(self::class, 'blocked_by_task_id');
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return \Database\Factories\TaskFactory::new();
    }
}
