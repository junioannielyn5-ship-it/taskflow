<?php

declare(strict_types=1);

use App\Modules\Shared\Helpers\DateHelper;
use App\Modules\Shared\Helpers\StringHelper;

// DateHelper tests
describe('DateHelper', function () {
    test('toUserTimezone returns correct timezone', function () {
        $dt = new DateTime('2026-02-20 12:00:00', new DateTimeZone('UTC'));
        $converted = DateHelper::toUserTimezone($dt, 'Asia/Manila');
        expect($converted->getTimezone()->getName())->toBe('Asia/Manila');
    });
    test('formatDate returns formatted string', function () {
        $dt = new DateTime('2026-02-20 12:00:00');
        expect(DateHelper::formatDate($dt, 'Y-m-d'))->toBe('2026-02-20');
    });
});

// StringHelper tests
describe('StringHelper', function () {
    test('truncate short string returns original', function () {
        expect(StringHelper::truncate('short', 10))->toBe('short');
    });
    test('truncate long string returns truncated', function () {
        expect(StringHelper::truncate('longstringhere', 4))->toBe('longs...');
    });
    test('slugify returns slug', function () {
        expect(StringHelper::slugify('Hello World!'))->toBe('hello-world-');
    });
});
