<?php

namespace Database\Factories;

use App\Modules\Identity\Models\User;
use App\Modules\Tasks\Models\Task;
use App\Modules\Workflow\Models\TaskActivityLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Modules\Workflow\Models\TaskActivityLog>
 */
class TaskActivityLogFactory extends Factory
{
    protected $model = TaskActivityLog::class;

    public function definition(): array
    {
        $oldStatus = fake()->randomElement(['todo', 'in_progress', 'blocked', 'for_review']);
        $newStatus = fake()->randomElement(['in_progress', 'blocked', 'for_review', 'done']);

        return [
            'task_id' => Task::factory(),
            'actor_id' => User::factory(),
            'action_type' => 'status_change',
            'old_value' => $oldStatus,
            'new_value' => $newStatus,
            'metadata' => null,
        ];
    }
}
