<?php

namespace Database\Factories;

use App\Modules\Attachments\Models\TaskAttachment;
use App\Modules\Identity\Models\User;
use App\Modules\Tasks\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Modules\Attachments\Models\TaskAttachment>
 */
class TaskAttachmentFactory extends Factory
{
    protected $model = TaskAttachment::class;

    public function definition(): array
    {
        $filename = fake()->randomElement(['spec.pdf', 'screenshot.png', 'report.xlsx', 'notes.txt']);

        return [
            'task_id' => Task::factory(),
            'user_id' => User::factory(),
            'path' => 'attachments/' . fake()->uuid() . '-' . $filename,
            'filename' => $filename,
            'mime_type' => fake()->randomElement([
                'application/pdf',
                'image/png',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'text/plain',
            ]),
            'size' => fake()->numberBetween(1024, 5 * 1024 * 1024),
        ];
    }
}
