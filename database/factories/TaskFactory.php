<?php

namespace Database\Factories;

use App\Modules\Identity\Models\User;
use App\Modules\Projects\Models\Project;
use App\Modules\Tasks\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Modules\Tasks\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $taskTitles = [
            'Define project scope',
            'Prepare stakeholder update',
            'Review design mockups',
            'Implement API endpoint',
            'Write unit tests',
            'Fix critical bug',
            'Update release notes',
            'Validate deployment checklist',
            'Refine reporting metrics',
            'Plan sprint backlog',
        ];

        return [
            'project_id' => Project::factory(),
            'title' => fake()->randomElement($taskTitles),
            'description' => fake()->randomElement([
                'Complete this task and document the outcome for team visibility.',
                'Coordinate with relevant members and update status after completion.',
                'Ensure acceptance criteria are met before marking this as done.',
            ]),
            'task_process' => fake()->randomElement(['For Support', 'For Quote', 'Endorsed', 'For Approval']),
            'company' => fake()->randomElement(['PBI', 'TOYOTA', 'Splash', 'Movaflex']),
            'team_in_charge' => fake()->randomElement(['Technical', 'Sales', 'Pre-sales']),
            'deliverables' => fake()->randomElement(['Test Report', 'Quotation', 'COC']),
            'remarks' => fake()->randomElement(['For review', 'Waiting for samples', 'Client follow-up required', null]),
            'priority' => 'medium',
            'date_received' => fake()->dateTimeBetween('-10 days', 'now'),
            'date_started' => fake()->dateTimeBetween('-7 days', '+2 days'),
            'due_date' => fake()->dateTimeBetween('+1 days', '+30 days'),
            'done_at' => null,
            'blocked_by_task_id' => null,
            'status' => 'todo', // Default to todo status
            'created_by' => User::factory(),
        ];
    }

    /**
     * Indicate that the task is completed.
     */
    public function done(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'done',
            'done_at' => now(),
        ]);
    }

    /**
     * Indicate that the task is in progress.
     */
    public function inProgress(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'in_progress',
        ]);
    }

    /**
     * Indicate that the task is urgent.
     */
    public function urgent(): static
    {
        return $this->state(fn (array $attributes) => [
            'priority' => 'urgent',
        ]);
    }

    /**
     * Indicate that the task has a past due date.
     */
    public function overdue(): static
    {
        return $this->state(fn (array $attributes) => [
            'due_date' => fake()->dateTimeBetween('-10 days', '-1 days'),
            'status' => 'todo',
        ]);

    }

    /**
     * Indicate this task is blocked by another task.
     */
    public function blockedBy(int $taskId): static
    {
        return $this->state(fn (array $attributes) => [
            'blocked_by_task_id' => $taskId,
            'status' => 'blocked',
        ]);
    }
}
