<?php

namespace App\Modules\Comments\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Modules\Comments\Models\Comment;
use App\Modules\Comments\Policies\CommentPolicy;

class CommentServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::policy(Comment::class, CommentPolicy::class);
    }
}
