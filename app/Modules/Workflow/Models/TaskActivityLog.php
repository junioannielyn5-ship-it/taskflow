<?php

namespace App\Modules\Workflow\Models;

use Database\Factories\TaskActivityLogFactory;
use App\Modules\Identity\Models\User;
use App\Modules\Tasks\Models\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskActivityLog extends Model
{
    /** @use HasFactory<\Database\Factories\TaskActivityLogFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'task_id',
        'actor_id',
        'action_type',
        'old_value',
        'new_value',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'metadata' => 'json',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the task this activity log belongs to.
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the user who performed this action.
     */
    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get a human-readable description of the action.
     */
    public function getDescription(): string
    {
        return match($this->action_type) {
            'status_change' => "Status changed from {$this->old_value} to {$this->new_value}",
            'assignee_change' => "Assignee changed from {$this->old_value} to {$this->new_value}",
            'priority_change' => "Priority changed from {$this->old_value} to {$this->new_value}",
            'due_date_change' => "Due date changed from {$this->old_value} to {$this->new_value}",
            'description_change' => "Description updated",
            'title_change' => "Title changed from {$this->old_value} to {$this->new_value}",
            default => ucwords(str_replace('_', ' ', $this->action_type)),
        };
    }

    /**
     * Backward-compatible alias for tests/legacy payloads.
     */
    public function setNewStatusAttribute(?string $value): void
    {
        $this->attributes['new_value'] = $value;
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return TaskActivityLogFactory::new();
    }
}
