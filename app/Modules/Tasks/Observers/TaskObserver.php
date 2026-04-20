<?php

namespace App\Modules\Tasks\Observers;

use App\Modules\Tasks\Models\Task;

class TaskObserver
{
    public function updated(Task $task)
    {
        return;
    }

    public function created(Task $task)
    {
        return;
    }
}
