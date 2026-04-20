<?php

namespace App\Modules\Notifications\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

class DailyExecutionSummaryNotification extends Notification
{
    use Queueable;

    public bool $mailOnly = false;

    /**
     * @var Collection<int, \App\Modules\Tasks\Models\Task>
     */
    public Collection $upcomingWithin24Hours;

    /**
     * @param Collection<string, Collection<int, \App\Modules\Tasks\Models\Task>> $delayedByTeam
     * @param Collection<int, \App\Modules\Tasks\Models\Task> $todayDeadlines
     */
    public function __construct(
        public Collection $delayedByTeam,
        public Collection $todayDeadlines,
        public int $ongoingCount,
        public int $activeCount,
        public string $dashboardUrl,
        public string $reportDate
    ) {
        $this->upcomingWithin24Hours = collect();
    }

    /**
     * @param Collection<int, \App\Modules\Tasks\Models\Task> $tasks
     */
    public function setUpcomingWithin24Hours(Collection $tasks): self
    {
        $this->upcomingWithin24Hours = $tasks;

        return $this;
    }

    public function via($notifiable): array
    {
        return $this->mailOnly ? ['mail'] : ['mail', 'database'];
    }

    public function asMailOnly(): self
    {
        $this->mailOnly = true;

        return $this;
    }

    public function toDatabase($notifiable): array
    {
        return [
            'message' => 'Daily Execution Summary sent for '.$this->reportDate,
            'status' => 'daily_execution_summary',
            'link' => $this->dashboardUrl,
            'delayed_total' => $this->delayedByTeam->flatten(1)->count(),
            'ongoing_count' => $this->ongoingCount,
            'active_count' => $this->activeCount,
        ];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('📊 Movaflex Daily Execution Summary - '.$this->reportDate)
            ->view('emails.daily-execution-summary', [
                'notifiable' => $notifiable,
                'delayedByTeam' => $this->delayedByTeam,
                'upcomingWithin24Hours' => $this->upcomingWithin24Hours,
                'todayDeadlines' => $this->todayDeadlines,
                'ongoingCount' => $this->ongoingCount,
                'activeCount' => $this->activeCount,
                'dashboardUrl' => $this->dashboardUrl,
                'reportDate' => $this->reportDate,
            ]);
    }
}
