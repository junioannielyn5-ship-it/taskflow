<?php

namespace App\Concerns;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

/**
 * Automatically log Created / Updated / Deleted events to the audit_logs table.
 *
 * Usage:  use \App\Concerns\LogsAuditTrail;
 *
 * Optional override in model:
 *   public function getAuditLabel(): string   – human-readable label (e.g. task_no)
 *   public array $auditExclude = ['updated_at', 'created_at'];
 */
trait LogsAuditTrail
{
    public static function bootLogsAuditTrail(): void
    {
        static::created(function ($model) {
            $model->logAudit('Created', [], $model->getAttributes());
        });

        static::updated(function ($model) {
            $changes = $model->getChanges();
            $excluded = array_merge(
                ['id', 'created_at', 'updated_at', 'deleted_at'],
                property_exists($model, 'auditExclude') ? $model->auditExclude : []
            );

            $old = [];
            $new = [];
            foreach ($changes as $key => $value) {
                if (in_array($key, $excluded, true)) {
                    continue;
                }
                $old[$key] = $model->getOriginal($key);
                $new[$key] = $value;
            }

            if (!empty($new)) {
                $model->logAudit('Updated', $old, $new);
            }
        });

        static::deleted(function ($model) {
            $model->logAudit('Deleted', $model->getOriginal(), []);
        });

        // If model uses SoftDeletes, log restores too
        if (method_exists(static::class, 'restored')) {
            static::restored(function ($model) {
                $model->logAudit('Restored', [], $model->getAttributes());
            });
        }
    }

    protected function logAudit(string $action, array $old, array $new): void
    {
        $userId = Auth::id();
        if (!$userId) {
            return; // Don't log unauthenticated actions (seeders, CLI)
        }

        AuditLog::create([
            'user_id'     => $userId,
            'action'      => $action,
            'model_type'  => static::class,
            'model_id'    => $this->getKey(),
            'model_label' => method_exists($this, 'getAuditLabel') ? $this->getAuditLabel() : null,
            'old_values'  => !empty($old) ? $old : null,
            'new_values'  => !empty($new) ? $new : null,
            'ip_address'  => Request::ip(),
        ]);
    }
}
