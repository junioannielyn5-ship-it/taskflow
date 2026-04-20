<?php

namespace App\Modules\Tasks\Providers;

use App\Modules\Tasks\Models\Task;
use App\Modules\Tasks\Policies\TaskPolicy;
use App\Modules\Tasks\Services\TaskService;
use Illuminate\Support\ServiceProvider;

class TaskServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(TaskService::class, function ($app) {
            return new TaskService(
                $app->make(\App\Modules\Projects\Services\ProjectService::class)
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register routes
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');

        // Register policies
        \Illuminate\Support\Facades\Gate::policy(Task::class, TaskPolicy::class);

        // Register route model bindings
        \Illuminate\Support\Facades\Route::model('project', \App\Modules\Projects\Models\Project::class);
        \Illuminate\Support\Facades\Route::model('task', Task::class);
    }
}
