<?php

namespace App\Modules\Tasks\Filters;

use App\Modules\Shared\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Builder;

class TaskFilters
{
    /**
     * Apply filters to the query.
     */
    public static function apply(Builder $query, array $filters): Builder
    {
        if (isset($filters['status']) && $filters['status']) {
            $normalizedStatus = TaskStatus::normalize($filters['status']);
            if ($normalizedStatus) {
                $query->whereRaw('LOWER(TRIM(status)) = ?', [$normalizedStatus]);
            }
        }

        if (isset($filters['priority']) && $filters['priority']) {
            $query->where('priority', $filters['priority']);
        }

        if (isset($filters['assignee']) && $filters['assignee']) {
            $query->whereHas('assignees', function ($q) use ($filters) {
                $q->where('user_id', $filters['assignee']);
            });
        }

        if (isset($filters['created_by']) && $filters['created_by']) {
            $query->where('created_by', $filters['created_by']);
        }

        if (isset($filters['overdue']) && $filters['overdue']) {
            $query->whereDate('due_date', '<', now()->toDateString())
                ->whereRaw('LOWER(TRIM(status)) != ?', [TaskStatus::DONE->value]);
        }

        if (isset($filters['due_date']) && $filters['due_date']) {
            $query->whereDate('due_date', $filters['due_date']);
        }

        if (isset($filters['company']) && $filters['company']) {
            $query->where('company', 'like', '%'.$filters['company'].'%');
        }

        if (isset($filters['date_received']) && $filters['date_received']) {
            $query->whereDate('date_received', $filters['date_received']);
        }

        if (isset($filters['blocked_by_task_id']) && $filters['blocked_by_task_id']) {
            $query->where('blocked_by_task_id', (int) $filters['blocked_by_task_id']);
        }

        if (isset($filters['search']) && $filters['search']) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('task_no', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('deliverables', 'like', "%{$search}%");
            });
        }

        return $query;
    }
}
