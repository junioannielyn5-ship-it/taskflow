<?php

namespace App\Modules\Automation\Listeners;

use App\Modules\Automation\Models\AutomationRule;
use App\Modules\Automation\Services\RuleEngine;
use App\Modules\Tasks\Events\TaskStatusChanged;

class HandleTaskStatusChangedAutomation
{
    public function __construct(private RuleEngine $ruleEngine)
    {
    }

    public function handle(TaskStatusChanged $event): void
    {
        $rules = AutomationRule::query()
            ->active()
            ->where('trigger_event', 'task.status_changed')
            ->get();

        foreach ($rules as $rule) {
            if (!$this->ruleEngine->evaluate($rule, $event->task, [
                'from_status' => $event->fromStatus,
                'to_status' => $event->toStatus,
            ])) {
                continue;
            }

            $this->ruleEngine->execute($rule, $event->task, [
                'from_status' => $event->fromStatus,
                'to_status' => $event->toStatus,
            ]);
        }
    }
}
