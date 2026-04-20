<?php

namespace App\Modules\Identity\Providers;

use App\Modules\Identity\Middleware\RoleMiddleware;
use Illuminate\Support\ServiceProvider;

class IdentityServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register routes
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');

        // Update the auth config to use Identity module's User model
        $this->app['config']['auth.providers.users.model'] = \App\Modules\Identity\Models\User::class;
    }
}
