<?php

namespace App\Modules\Notifications\Notifications;

use App\Modules\Tasks\Models\Task;
use App\Modules\Tasks\Models\TaskChecklistItem;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskChecklistUpdatedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Task $task,
        public TaskChecklistItem $item,
        public bool $isCompleted,
        public ?string $actorName = null
    ) {}

    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toDatabase($notifiable): array
    {
        $stateLabel = $this->isCompleted ? 'checked' : 'unchecked';
        $actorPrefix = $this->actorName ? $this->actorName.' ' : '';

        return [
            'message' => $actorPrefix.'updated checklist item "'.$this->item->title.'" ('.$stateLabel.') in '.$this->task->title,
            'task_id' => $this->task->id,
            'checklist_item_id' => $this->item->id,
            'checklist_item_title' => $this->item->title,
            'is_completed' => $this->isCompleted,
            'link' => route('tasks.show', $this->task),
        ];
    }

    public function toMail($notifiable): MailMessage
    {
        $stateLabel = $this->isCompleted ? 'completed' : 'reopened';
        $actorText = $this->actorName ? $this->actorName.' updated a checklist item.' : 'A checklist item was updated.';

        return (new MailMessage)
            ->subject('Task Checklist Update: '.$this->task->title)
            ->greeting('Hello '.($notifiable->name ?? 'Team').',')
            ->line($actorText)
            ->line('Task: '.$this->task->title)
            ->line('Checklist Item: '.$this->item->title)
            ->line('Update: '.$stateLabel)
            ->action('Open Task', route('tasks.show', $this->task));
    }
}
