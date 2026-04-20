<?php

namespace App\Modules\Notifications\Notifications;

use App\Modules\Tasks\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TaskDeadlineDashboardNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Task $task,
        public string $level,
        public int $daysLeft,
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'message' => $this->buildMessage(),
            'task_id' => $this->task->id,
            'deadline_level' => $this->level,
            'days_left' => $this->daysLeft,
            'link' => route('tasks.show', $this->task),
        ];
    }

    private function buildMessage(): string
    {
        return match ($this->level) {
            'warning' => 'Warning: Task "'.$this->task->title.'" is due in 7 days.',
            'critical' => 'Critical: Task "'.$this->task->title.'" is due in 3 days.',
            'reminder' => 'Reminder: Task "'.$this->task->title.'" is due today.',
            'overdue' => 'Overdue: Task "'.$this->task->title.'" has passed its deadline.',
            default => 'Deadline update for task "'.$this->task->title.'".',
        };
    }
}
