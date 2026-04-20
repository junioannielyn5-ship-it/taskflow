<?php

namespace App\Modules\Automation\Providers;

use App\Modules\Automation\Console\RunDailyAutomationRules;
use App\Modules\Automation\Listeners\HandleTaskStatusChangedAutomation;
use App\Modules\Automation\Services\RuleEngine;
use App\Modules\Automation\Services\SystemActorResolver;
use App\Modules\Tasks\Events\TaskStatusChanged;
use Illuminate\Support\ServiceProvider;

class AutomationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SystemActorResolver::class, fn () => new SystemActorResolver());
        $this->app->singleton(RuleEngine::class, fn ($app) => new RuleEngine($app->make(SystemActorResolver::class)));
    }

    public function boot(): void
    {
        $this->commands([
            RunDailyAutomationRules::class,
        ]);

        $this->app['events']->listen(TaskStatusChanged::class, HandleTaskStatusChangedAutomation::class);
    }
}
