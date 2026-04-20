<?php

namespace App\Modules\Shared\Enums;

enum TaskStatus: string
{
    case TODO = 'todo';
    case IN_PROGRESS = 'in_progress';
    case BLOCKED = 'blocked';
    case FOR_REVIEW = 'for_review';
    case DONE = 'done';
    case CANCELLED = 'cancelled';

    /**
     * Canonical list for modules that accept all task statuses.
     *
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(static fn (self $status) => $status->value, self::cases());
    }

    /**
     * Workflow-enabled statuses (excludes cancelled transitions).
     *
     * @return list<string>
     */
    public static function workflowValues(): array
    {
        return [
            self::TODO->value,
            self::IN_PROGRESS->value,
            self::BLOCKED->value,
            self::FOR_REVIEW->value,
            self::DONE->value,
        ];
    }

    /**
     * Normalize incoming status labels (including legacy spreadsheet terms)
     * to canonical enum values.
     */
    public static function normalize(?string $status): ?string
    {
        if (is_null($status)) {
            return null;
        }

        $normalized = strtolower(trim($status));

        return match ($normalized) {
            'on-going', 'on going', 'ongoing', 'in progress' => self::IN_PROGRESS->value,
            'pending req', 'pending req.', 'pending request', 'pending requirements', 'backlog' => self::BLOCKED->value,
            'for review' => self::FOR_REVIEW->value,
            'to do' => self::TODO->value,
            'canceled' => self::CANCELLED->value,
            default => str_replace(' ', '_', $normalized),
        };
    }
}
