<?php

namespace App\Modules\Workflow\Providers;

use App\Modules\Tasks\Events\TaskCreated;
use App\Modules\Tasks\Events\TaskStatusChanged;
use App\Modules\Tasks\Events\TaskUpdated;
use App\Modules\Tasks\Models\Task;
use App\Modules\Workflow\Listeners\RecordTaskActivity;
use App\Modules\Workflow\Services\WorkflowService;
use Illuminate\Support\ServiceProvider;

class WorkflowServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(WorkflowService::class, function ($app) {
            return new WorkflowService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register routes
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');

        // Register route model bindings (ensure Task binding is set)
        \Illuminate\Support\Facades\Route::model('task', Task::class);

        // Register event listeners
        $this->app['events']->listen(TaskCreated::class, [RecordTaskActivity::class, 'handleTaskCreated']);
        $this->app['events']->listen(TaskStatusChanged::class, [RecordTaskActivity::class, 'handleTaskStatusChanged']);
        $this->app['events']->listen(TaskUpdated::class, [RecordTaskActivity::class, 'handleTaskUpdate']);
    }
}
