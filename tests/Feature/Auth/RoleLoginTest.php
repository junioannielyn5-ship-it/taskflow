<?php

use App\Models\User;

test('member can login via member role page', function () {
    $user = User::factory()->create([
        'email' => 'member-role@test.com',
        'password' => 'password',
        'role' => 'member',
    ]);

    $response = $this->post(route('role.login.attempt', ['role' => 'member']), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertRedirect(route('tasks.kanban', absolute: false));
    $this->assertAuthenticatedAs($user);
});

test('team lead alias route can login lead users', function () {
    $user = User::factory()->create([
        'email' => 'lead-role@test.com',
        'password' => 'password',
        'role' => 'lead',
    ]);

    $response = $this->post(route('role.login.attempt', ['role' => 'team-lead']), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertRedirect(route('lead.index', absolute: false));
    $this->assertAuthenticatedAs($user);
});

test('project manager login accepts pm alias user role', function () {
    $user = User::factory()->create([
        'email' => 'pm-role@test.com',
        'password' => 'password',
        'role' => 'pm',
    ]);

    $response = $this->post(route('role.login.attempt', ['role' => 'project-manager']), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertRedirect(route('project-manager.index', absolute: false));
    $this->assertAuthenticatedAs($user);
});

test('admin can login via admin role page', function () {
    $user = User::factory()->create([
        'email' => 'admin-role@test.com',
        'password' => 'password',
        'role' => 'admin',
    ]);

    $response = $this->post(route('role.login.attempt', ['role' => 'admin']), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertRedirect(route('admin.index', absolute: false));
    $this->assertAuthenticatedAs($user);
});

test('member cannot login through admin role page', function () {
    $user = User::factory()->create([
        'email' => 'member-as-admin@test.com',
        'password' => 'password',
        'role' => 'member',
    ]);

    $response = $this->from(route('role.login.show', ['role' => 'admin']))
        ->post(route('role.login.attempt', ['role' => 'admin']), [
            'email' => $user->email,
            'password' => 'password',
        ]);

    $response->assertRedirect(route('role.login.show', ['role' => 'admin']));
    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});
