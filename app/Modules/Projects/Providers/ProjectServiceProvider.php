<?php

namespace App\Modules\Projects\Providers;

use App\Modules\Projects\Models\Project;
use App\Modules\Projects\Policies\ProjectPolicy;
use App\Modules\Projects\Services\ProjectService;
use Illuminate\Support\ServiceProvider;

class ProjectServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ProjectService::class, function ($app) {
            return new ProjectService();
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
        \Illuminate\Support\Facades\Gate::policy(Project::class, ProjectPolicy::class);
    }
}
