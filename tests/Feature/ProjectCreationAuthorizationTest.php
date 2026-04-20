<?php

describe('Project Creation Authorization', function () {
    it('prevents Member from accessing create project page', function () {
        $user = \App\Models\User::factory()->create();
        $user->roles()->attach(\App\Models\Role::where('name', 'member')->first());
        $this->actingAs($user);
        $response = $this->get(route('projects.create'));
        $response->assertForbidden();
    });

    it('allows Admin to access create project page', function () {
        $user = \App\Models\User::factory()->create();
        $user->roles()->attach(\App\Models\Role::where('name', 'admin')->first());
        $this->actingAs($user);
        $response = $this->get(route('projects.create'));
        $response->assertOk();
    });

    it('allows Manager to access create project page', function () {
        $user = \App\Models\User::factory()->create();
        $user->roles()->attach(\App\Models\Role::where('name', 'manager')->first());
        $this->actingAs($user);
        $response = $this->get(route('projects.create'));
        $response->assertOk();
    });
});
