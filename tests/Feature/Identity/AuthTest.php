<?php

use App\Modules\Identity\Models\User;

describe('AuthController', function () {
    describe('login', function () {
        test('user_can_login_with_valid_credentials', function () {
            // Create a test user
            $user = User::factory()->create([
                'email' => 'test@example.com',
                'password' => 'password123',
                'role' => 'member',
            ]);

            // Attempt login
            $response = $this->postJson(route('identity.login'), [
                'email' => 'test@example.com',
                'password' => 'password123',
            ]);

            $response->assertOk();
            $response->assertJsonStructure([
                'message',
                'user' => ['id', 'name', 'email', 'role'],
            ]);

            // User should be authenticated
            $this->assertAuthenticatedAs($user);
        });

        test('login_fails_with_invalid_credentials', function () {
            User::factory()->create([
                'email' => 'test@example.com',
                'password' => 'password123',
            ]);

            $response = $this->postJson(route('identity.login'), [
                'email' => 'test@example.com',
                'password' => 'wrongpassword',
            ]);

            $response->assertUnauthorized();
            $response->assertJsonStructure(['message']);
            $this->assertGuest();
        });

        test('login_fails_with_missing_email', function () {
            $response = $this->postJson(route('identity.login'), [
                'password' => 'password123',
            ]);

            $response->assertUnprocessable();
            $response->assertJsonValidationErrors(['email']);
        });

        test('login_fails_with_missing_password', function () {
            $response = $this->postJson(route('identity.login'), [
                'email' => 'test@example.com',
            ]);

            $response->assertUnprocessable();
            $response->assertJsonValidationErrors(['password']);
        });
    });

    describe('logout', function () {
        test('authenticated_user_can_logout', function () {
            $user = User::factory()->create();
            $this->actingAs($user);

            $response = $this->postJson(route('identity.logout'));

            $response->assertOk();
            $response->assertJsonStructure(['message']);
            $this->assertGuest();
        });

        test('unauthenticated_user_cannot_logout', function () {
            $response = $this->postJson(route('identity.logout'));

            $response->assertUnauthorized();
        });
    });

    describe('role-based access control', function () {
        test('unauthorized_user_is_blocked_from_admin_routes', function () {
            // Create a member user
            $user = User::factory()->create([
                'role' => 'member',
            ]);

            $this->actingAs($user);

            // Try to access admin route
            $response = $this->getJson(route('identity.admin.dashboard'));

            $response->assertForbidden();
            $response->assertJsonStructure(['message']);
        });

        test('admin_user_can_access_admin_routes', function () {
            // Create an admin user
            $user = User::factory()->create([
                'role' => 'admin',
            ]);

            $this->actingAs($user);

            // Access admin route
            $response = $this->getJson(route('identity.admin.dashboard'));

            $response->assertOk();
            $response->assertJsonStructure(['message']);
        });

        test('unauthenticated_user_cannot_access_admin_routes', function () {
            // Try to access admin route without being authenticated
            $response = $this->getJson(route('identity.admin.dashboard'));

            $response->assertUnauthorized();
        });

        test('user_with_different_role_is_blocked', function () {
            // Create a PM user
            $user = User::factory()->create([
                'role' => 'pm',
            ]);

            $this->actingAs($user);

            // Try to access admin route
            $response = $this->getJson(route('identity.admin.dashboard'));

            $response->assertForbidden();
        });
    });

    describe('user role methods', function () {
        test('user_can_check_admin_role', function () {
            $adminUser = User::factory()->create(['role' => 'admin']);
            $memberUser = User::factory()->create(['role' => 'member']);

            expect($adminUser->isAdmin())->toBeTrue();
            expect($memberUser->isAdmin())->toBeFalse();
        });

        test('user_can_check_pm_role', function () {
            $pmUser = User::factory()->create(['role' => 'pm']);
            $memberUser = User::factory()->create(['role' => 'member']);

            expect($pmUser->isPM())->toBeTrue();
            expect($memberUser->isPM())->toBeFalse();
        });

        test('user_can_check_lead_role', function () {
            $leadUser = User::factory()->create(['role' => 'lead']);
            $memberUser = User::factory()->create(['role' => 'member']);

            expect($leadUser->isLead())->toBeTrue();
            expect($memberUser->isLead())->toBeFalse();
        });

        test('user_can_check_member_role', function () {
            $memberUser = User::factory()->create(['role' => 'member']);
            $adminUser = User::factory()->create(['role' => 'admin']);

            expect($memberUser->isMember())->toBeTrue();
            expect($adminUser->isMember())->toBeFalse();
        });

        test('user_can_check_specific_role_with_hasRole', function () {
            $user = User::factory()->create(['role' => 'lead']);

            expect($user->hasRole('lead'))->toBeTrue();
            expect($user->hasRole('member'))->toBeFalse();
        });

        test('user_can_check_many_roles_with_hasAnyRole', function () {
            $leadUser = User::factory()->create(['role' => 'lead']);
            $memberUser = User::factory()->create(['role' => 'member']);

            expect($leadUser->hasAnyRole(['lead', 'pm']))->toBeTrue();
            expect($memberUser->hasAnyRole(['admin', 'pm']))->toBeFalse();
            expect($memberUser->hasAnyRole(['member', 'lead']))->toBeTrue();
        });
    });
});
