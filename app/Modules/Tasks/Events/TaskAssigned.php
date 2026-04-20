<?php

namespace App\Modules\Tasks\Events;

use App\Modules\Identity\Models\User;
use App\Modules\Tasks\Models\Task;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskAssigned
{
    use Dispatchable, SerializesModels;

    public function __construct(public Task $task, public ?User $actor = null)
    {
    }
}
