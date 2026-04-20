<?php

namespace App\Models;

use App\Modules\Identity\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AuditLog extends Model
{
    protected $table = 'audit_logs';

    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'model_label',
        'old_values',
        'new_values',
        'ip_address',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    // ── Relationships ──

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function auditable(): MorphTo
    {
        return $this->morphTo('auditable', 'model_type', 'model_id');
    }

    // ── Helpers ──

    public function getChangedFieldsAttribute(): array
    {
        $old = $this->old_values ?? [];
        $new = $this->new_values ?? [];

        return array_keys(array_merge($old, $new));
    }

    public function getChangesSummaryAttribute(): string
    {
        if ($this->action === 'Created') {
            return 'Created ' . class_basename($this->model_type) . ' ' . ($this->model_label ?? '#' . $this->model_id);
        }

        if ($this->action === 'Deleted') {
            return 'Deleted ' . class_basename($this->model_type) . ' ' . ($this->model_label ?? '#' . $this->model_id);
        }

        $parts = [];
        $old = $this->old_values ?? [];
        $new = $this->new_values ?? [];

        foreach ($new as $field => $newVal) {
            $oldVal = $old[$field] ?? '—';
            $label = str_replace('_', ' ', $field);
            $parts[] = "Changed {$label} from \"{$oldVal}\" to \"{$newVal}\"";
        }

        return implode('. ', $parts) ?: 'Updated record';
    }
}
