<?php

declare(strict_types=1);

use App\Modules\Shared\Traits\ApiResponse;

describe('ApiResponse Trait', function () {
    test('api_response_trait_returns_correct_json_format', function () {
        $controller = new class {
            use ApiResponse;
        };
        $response = $controller->sendResponse(['foo' => 'bar'], 'Success', 200);
        $json = $response->getData(true);
        expect($json['status'])->toBe('success');
        expect($json['message'])->toBe('Success');
        expect($json['data'])->toBe(['foo' => 'bar']);
    });

    test('api_response_trait_returns_error_format', function () {
        $controller = new class {
            use ApiResponse;
        };
        $response = $controller->sendError('Error occurred', 422, ['foo' => 'bar']);
        $json = $response->getData(true);
        expect($json['status'])->toBe('error');
        expect($json['message'])->toBe('Error occurred');
        expect($json['data'])->toBe(['foo' => 'bar']);
    });
});
