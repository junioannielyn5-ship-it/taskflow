<?php

namespace App\Modules\Comments\Providers;

use App\Modules\Comments\Models\TaskComment;
use App\Modules\Comments\Policies\CommentPolicy;
use Illuminate\Support\ServiceProvider;

class CommentsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register routes
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');

        // Register policies
        \Illuminate\Support\Facades\Gate::policy(TaskComment::class, CommentPolicy::class);

        // Register route model bindings
        \Illuminate\Support\Facades\Route::model('comment', TaskComment::class);
    }
}
