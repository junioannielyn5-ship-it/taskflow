<?php

describe('Role-based Access', function () {
    it('prevents non-admin from accessing admin route', function () {
        $user = \App\Models\User::factory()->create();
        $role = \App\Models\Role::firstOrCreate(['name' => 'member']);
        $user->roles()->attach($role);
        $this->actingAs($user);
        $response = $this->get('/admin/dashboard');
        $response->assertStatus(403);
    });

    it('allows admin to access admin route', function () {
        $user = \App\Models\User::factory()->create();
        $role = \App\Models\Role::firstOrCreate(['name' => 'admin']);
        $user->roles()->attach($role);
        $this->actingAs($user);
        $response = $this->get('/admin/dashboard');
        $response->assertStatus(200);
    });
});
