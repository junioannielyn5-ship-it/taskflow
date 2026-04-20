<?php

use App\Modules\Identity\Models\User;
use App\Modules\Projects\Models\Project;
use App\Modules\Projects\Models\ProjectMember;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\patchJson;
use function Pest\Laravel\postJson;

describe('ProjectController', function () {
    describe('project creation', function () {
        test('only_authorized_roles_can_create_projects', function () {
            // Admin can create
            $adminUser = User::factory()->create(['role' => 'admin']);
            actingAs($adminUser);
            $response = postJson(route('projects.store'), [
                'name' => 'Admin Project',
                'description' => 'A project created by admin',
            ]);
            $response->assertCreated();
            assertDatabaseHas('projects', ['name' => 'Admin Project']);

            // PM can create
            $pmUser = User::factory()->create(['role' => 'pm']);
            actingAs($pmUser);
            $response = postJson(route('projects.store'), [
                'name' => 'PM Project',
            ]);
            $response->assertCreated();

            // Member cannot create
            $memberUser = User::factory()->create(['role' => 'member']);
            actingAs($memberUser);
            $response = postJson(route('projects.store'), [
                'name' => 'Member Project',
            ]);
            $response->assertForbidden();

            // Lead can create
            $leadUser = User::factory()->create(['role' => 'lead']);
            actingAs($leadUser);
            $response = postJson(route('projects.store'), [
                'name' => 'Lead Project',
            ]);
            $response->assertCreated();
        });

        test('project_creation_requires_valid_data', function () {
            $adminUser = User::factory()->create(['role' => 'admin']);

            // Missing name
            actingAs($adminUser);
            $response = postJson(route('projects.store'), [
                'description' => 'No name project',
            ]);
            $response->assertUnprocessable();
            $response->assertJsonValidationErrors('name');

            // Name too long
            actingAs($adminUser);
            $response = postJson(route('projects.store'), [
                'name' => str_repeat('a', 256),
            ]);
            $response->assertUnprocessable();
        });

        test('creator_becomes_project_lead', function () {
            $adminUser = User::factory()->create(['role' => 'admin']);

            actingAs($adminUser);
            $response = postJson(route('projects.store'), [
                'name' => 'Test Project',
            ]);

            $project = Project::where('name', 'Test Project')->first();
            assertDatabaseHas('project_members', [
                'project_id' => $project->id,
                'user_id' => $adminUser->id,
                'role' => 'lead',
            ]);
        });

        test('unauthenticated_user_cannot_create_project', function () {
            $response = postJson(route('projects.store'), [
                'name' => 'Test Project',
            ]);
            $response->assertUnauthorized();
        });
    });

    describe('project visibility', function () {
        test('user_can_only_see_projects_they_are_members_of', function () {
            $admin = User::factory()->create(['role' => 'admin']);
            $member = User::factory()->create(['role' => 'member']);
            $otherUser = User::factory()->create(['role' => 'member']);

            // Admin creates project
            $project = Project::factory()->create(['created_by' => $admin->id]);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $admin->id, 'role' => 'lead']);

            // Add member to project
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $member->id, 'role' => 'member']);

            // Member can view their projects list
            actingAs($member);
            $response = getJson(route('projects.index'));
            $response->assertOk();
            expect($response->json('count'))->toBe(1);

            // Other user cannot see the project in their list
            actingAs($otherUser);
            $response = getJson(route('projects.index'));
            $response->assertOk();
            expect($response->json('count'))->toBe(0);

            // Non-member cannot view project details
            actingAs($otherUser);
            $response = getJson(route('projects.show', $project));
            $response->assertForbidden();

            // Member can view project details
            actingAs($member);
            $response = getJson(route('projects.show', $project));
            $response->assertOk();
        });

        test('admin_can_view_all_projects', function () {
            $admin = User::factory()->create(['role' => 'admin']);
            $member = User::factory()->create(['role' => 'member']);

            $project = Project::factory()->create(['created_by' => $member->id]);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $member->id, 'role' => 'lead']);

            // Admin can view anyone's project
            actingAs($admin);
            $response = getJson(route('projects.show', $project));
            $response->assertOk();
        });
    });

    describe('membership management', function () {
        test('project_lead_can_add_members_to_project', function () {
            $admin = User::factory()->create(['role' => 'admin']);
            $member = User::factory()->create(['role' => 'member']);
            $newUser = User::factory()->create(['role' => 'member']);

            $project = Project::factory()->create(['created_by' => $admin->id]);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $admin->id, 'role' => 'lead']);

            // Admin (project lead) can add member
            actingAs($admin);
            $response = postJson(
                route('projects.addMember', $project),
                ['user_id' => $newUser->id, 'role' => 'member']
            );
            $response->assertCreated();
            assertDatabaseHas('project_members', [
                'project_id' => $project->id,
                'user_id' => $newUser->id,
                'role' => 'member',
            ]);
        });

        test('non_lead_cannot_add_members', function () {
            $creator = User::factory()->create(['role' => 'admin']);
            $member = User::factory()->create(['role' => 'member']);
            $newUser = User::factory()->create(['role' => 'member']);

            $project = Project::factory()->create(['created_by' => $creator->id]);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $creator->id, 'role' => 'lead']);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $member->id, 'role' => 'member']);

            // Member cannot add members
            actingAs($member);
            $response = postJson(
                route('projects.addMember', $project),
                ['user_id' => $newUser->id]
            );
            $response->assertForbidden();
        });

        test('project_lead_can_remove_members', function () {
            $creator = User::factory()->create(['role' => 'admin']);
            $member = User::factory()->create(['role' => 'member']);

            $project = Project::factory()->create(['created_by' => $creator->id]);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $creator->id, 'role' => 'lead']);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $member->id, 'role' => 'member']);

            // Lead can remove member
            actingAs($creator);
            $response = deleteJson(
                route('projects.removeMember', ['project' => $project, 'userId' => $member->id])
            );
            $response->assertOk();
            assertDatabaseMissing('project_members', [
                'project_id' => $project->id,
                'user_id' => $member->id,
            ]);
        });

        test('can_get_project_members', function () {
            $creator = User::factory()->create(['role' => 'admin']);
            $member1 = User::factory()->create(['role' => 'member']);
            $member2 = User::factory()->create(['role' => 'member']);

            $project = Project::factory()->create(['created_by' => $creator->id]);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $creator->id, 'role' => 'lead']);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $member1->id, 'role' => 'member']);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $member2->id, 'role' => 'member']);

            actingAs($creator);
            $response = getJson(route('projects.getMembers', $project));
            $response->assertOk();
            expect($response->json('count'))->toBe(3);
        });
    });

    describe('project update and delete', function () {
        test('only_authorized_users_can_update_project', function () {
            $creator = User::factory()->create(['role' => 'admin']);
            $lead = User::factory()->create(['role' => 'member']);
            $member = User::factory()->create(['role' => 'member']);

            $project = Project::factory()->create(['created_by' => $creator->id, 'name' => 'Original Name']);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $creator->id, 'role' => 'lead']);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $lead->id, 'role' => 'lead']);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $member->id, 'role' => 'member']);

            // Creator can update
            actingAs($creator);
            $response = patchJson(
                route('projects.update', $project),
                ['name' => 'Updated by Creator']
            );
            $response->assertOk();

            // Lead can update
            actingAs($lead);
            $response = patchJson(
                route('projects.update', $project),
                ['name' => 'Updated by Lead']
            );
            $response->assertOk();

            // Member cannot update
            actingAs($member);
            $response = patchJson(
                route('projects.update', $project),
                ['name' => 'Updated by Member']
            );
            $response->assertForbidden();
        });

        test('only_creator_and_admin_can_delete_project', function () {
            $creator = User::factory()->create(['role' => 'admin']);
            $admin = User::factory()->create(['role' => 'admin']);
            $lead = User::factory()->create(['role' => 'member']);

            $project1 = Project::factory()->create(['created_by' => $creator->id]);
            ProjectMember::create(['project_id' => $project1->id, 'user_id' => $creator->id, 'role' => 'lead']);
            ProjectMember::create(['project_id' => $project1->id, 'user_id' => $lead->id, 'role' => 'lead']);

            // Creator can delete
            actingAs($creator);
            $response = deleteJson(route('projects.destroy', $project1));
            $response->assertOk();

            $project2 = Project::factory()->create(['created_by' => $creator->id]);
            ProjectMember::create(['project_id' => $project2->id, 'user_id' => $creator->id, 'role' => 'lead']);

            // Admin can delete any project
            actingAs($admin);
            $response = deleteJson(route('projects.destroy', $project2));
            $response->assertOk();

            $project3 = Project::factory()->create(['created_by' => $creator->id]);
            ProjectMember::create(['project_id' => $project3->id, 'user_id' => $creator->id, 'role' => 'lead']);
            ProjectMember::create(['project_id' => $project3->id, 'user_id' => $lead->id, 'role' => 'lead']);

            // Lead cannot delete
            actingAs($lead);
            $response = deleteJson(route('projects.destroy', $project3));
            $response->assertForbidden();
        });
    });

    describe('integration with identity module', function () {
        test('project_service_can_check_membership', function () {
            $user = User::factory()->create(['role' => 'member']);
            $otherUser = User::factory()->create(['role' => 'member']);

            $project = Project::factory()->create(['created_by' => $user->id]);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $user->id, 'role' => 'lead']);

            $projectService = app(\App\Modules\Projects\Services\ProjectService::class);

            // User is member
            expect($projectService->isMember($project->id, $user->id))->toBeTrue();

            // Other user is not member
            expect($projectService->isMember($project->id, $otherUser->id))->toBeFalse();
        });

        test('project_service_can_check_user_role_in_project', function () {
            $user = User::factory()->create(['role' => 'member']);
            $project = Project::factory()->create(['created_by' => $user->id]);
            ProjectMember::create(['project_id' => $project->id, 'user_id' => $user->id, 'role' => 'lead']);

            $projectService = app(\App\Modules\Projects\Services\ProjectService::class);

            expect($projectService->isLead($project->id, $user->id))->toBeTrue();
            expect($projectService->getUserRole($project->id, $user->id))->toBe('lead');
        });
    });
});
