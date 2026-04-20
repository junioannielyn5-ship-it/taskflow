<?php

use App\Modules\Admin\Models\TaskCompany;
use App\Modules\Identity\Models\User;

describe('Admin Configuration audit logging', function () {
    test('manager company create is logged in admin audit logs only', function () {
        $manager = User::factory()->create(['role' => 'manager']);

        $this->actingAs($manager)
            ->post(route('admin.config.companies.store'), [
                'name' => 'Acme Client',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('task_companies', [
            'name' => 'Acme Client',
        ]);

        $this->assertDatabaseHas('admin_audit_logs', [
            'admin_id' => $manager->id,
            'action' => 'client_created',
        ]);

        $this->assertDatabaseMissing('task_activity_logs', [
            'action_type' => 'client_created',
            'actor_id' => $manager->id,
        ]);
    });

    test('manager company delete is logged in admin audit logs only', function () {
        $manager = User::factory()->create(['role' => 'manager']);
        $company = TaskCompany::query()->create([
            'name' => 'Delete Me Client',
            'is_active' => true,
        ]);

        $this->actingAs($manager)
            ->delete(route('admin.config.companies.delete', $company))
            ->assertRedirect();

        $this->assertDatabaseHas('admin_audit_logs', [
            'admin_id' => $manager->id,
            'action' => 'client_deleted',
        ]);

        $this->assertDatabaseMissing('task_activity_logs', [
            'action_type' => 'client_deleted',
            'actor_id' => $manager->id,
        ]);
    });
});
