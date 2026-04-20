<?php

namespace Tests;

use App\Modules\Identity\Models\User;
use App\Modules\Projects\Models\Project;
use App\Modules\Workflow\Services\WorkflowService;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * Shared testing base for Pest/Laravel tests.
 *
 * Pest tests commonly attach dynamic properties inside beforeEach callbacks.
 * These annotations keep editor/static analysis in sync with runtime behavior.
 *
 * @property WorkflowService $workflowService
 * @property User $lead
 * @property User $member
 * @property User $admin
 * @property Project $project
 */
abstract class TestCase extends BaseTestCase
{
    protected bool $seed = true;

    protected string $seeder = \Database\Seeders\RoleSeeder::class;

    public WorkflowService $workflowService;

    public User $lead;

    public User $member;

    public User $admin;

    public Project $project;
}
