<?php

declare(strict_types=1);

use App\Modules\Shared\Enums\TaskStatus;
use App\Modules\Shared\Enums\TaskPriority;
use App\Modules\Shared\Enums\ProjectStatus;

describe('Enums', function () {
    test('enums_return_expected_values', function () {
        expect(TaskStatus::TODO->value)->toBe('todo');
        expect(TaskPriority::HIGH->value)->toBe('high');
        expect(ProjectStatus::PENDING_REQUEST->value)->toBe('pending_request');
    });

    test('task_status_normalizes_legacy_spreadsheet_labels', function () {
        expect(TaskStatus::normalize('ON-GOING'))->toBe(TaskStatus::IN_PROGRESS->value)
            ->and(TaskStatus::normalize('PENDING REQ'))->toBe(TaskStatus::BLOCKED->value)
            ->and(TaskStatus::normalize('BACKLOG'))->toBe(TaskStatus::BLOCKED->value)
            ->and(TaskStatus::normalize('DONE'))->toBe(TaskStatus::DONE->value);
    });
});
