<?php

namespace App\Modules\Automation\Console;

use App\Modules\Automation\Models\AutomationRule;
use App\Modules\Automation\Services\RuleEngine;
use App\Modules\Shared\Enums\TaskStatus;
use App\Modules\Tasks\Models\Task;
use Illuminate\Console\Command;

class RunDailyAutomationRules extends Command
{
    protected $signature = 'automation:run-daily';

    protected $description = 'Run daily automation rules against tasks';

    public function __construct(private RuleEngine $ruleEngine)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $rules = AutomationRule::query()
            ->active()
            ->where('trigger_event', 'scheduled.daily')
            ->get();

        if ($rules->isEmpty()) {
            $this->info('No active daily automation rules found.');
            return self::SUCCESS;
        }

        $tasks = Task::query()
            ->with(['project.members', 'assignees'])
            ->where('status', '!=', TaskStatus::DONE->value)
            ->get();

        $applied = 0;

        foreach ($tasks as $task) {
            if (!$task instanceof Task) {
                continue;
            }

            foreach ($rules as $rule) {
                if (!$this->ruleEngine->evaluate($rule, $task, ['event' => 'scheduled.daily'])) {
                    continue;
                }

                $this->ruleEngine->execute($rule, $task, ['event' => 'scheduled.daily']);
                $applied++;
            }
        }

        $this->info('Applied automation actions: '.$applied);

        return self::SUCCESS;
    }
}
