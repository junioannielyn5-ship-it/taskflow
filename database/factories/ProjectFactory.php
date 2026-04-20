<?php

namespace Database\Factories;

use App\Modules\Identity\Models\User;
use App\Modules\Projects\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Modules\Projects\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $projectNames = [
            'Website Redesign',
            'Mobile App Launch',
            'Customer Support Portal',
            'Billing System Upgrade',
            'Marketing Campaign Tracker',
            'HR Onboarding Workflow',
            'Sales Pipeline Dashboard',
            'Inventory Sync Platform',
            'Team Productivity Hub',
            'Data Migration Project',
        ];

        return [
            'name' => fake()->randomElement($projectNames).' '.fake()->numberBetween(1, 99),
            'description' => fake()->randomElement([
                'Improve workflow visibility and delivery tracking across the team.',
                'Coordinate milestones, owners, and deliverables for cross-functional work.',
                'Support planning, execution, and reporting for ongoing operational tasks.',
            ]),
            'status' => fake()->randomElement(['pending_request', 'ongoing']),
            'created_by' => User::factory(),
        ];
    }

    /**
     * Indicate that the project is archived.
     */
    public function archived(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending_request',
        ]);
    }

    /**
     * Indicate that the project is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'ongoing',
        ]);
    }
}
