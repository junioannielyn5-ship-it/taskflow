<?php

namespace App\Modules\Shared\Enums;

enum TaskPriority: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
    case URGENT = 'urgent';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(static fn (self $priority) => $priority->value, self::cases());
    }
}
