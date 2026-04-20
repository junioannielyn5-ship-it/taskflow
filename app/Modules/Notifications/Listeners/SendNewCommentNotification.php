<?php

namespace App\Modules\Notifications\Listeners;

use App\Modules\Comments\Events\CommentCreated;
use App\Modules\Identity\Models\User;
use App\Modules\Notifications\Notifications\NewCommentNotification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class SendNewCommentNotification
{
    public function handle(CommentCreated $event): void
    {
        $task = $event->comment->task->loadMissing(['assignees', 'project.members.user']);

        $mentionedUsers = $this->resolveMentionedUsers($event->comment->body, $task->project?->members?->pluck('user')->filter() ?? collect());

        $recipients = $task->assignees
            ->keyBy('id')
            ->merge($mentionedUsers->keyBy('id'));

        foreach ($recipients as $user) {
            if (! $user instanceof User) {
                continue;
            }

            if ((int) $user->id === (int) $event->comment->user_id) {
                continue;
            }

            try {
                $user->notify(new NewCommentNotification($task, $event->comment));
            } catch (\Throwable $e) {
                Log::error('Failed to send new comment notification: ' . $e->getMessage());
            }
        }
    }

    private function resolveMentionedUsers(string $body, Collection $projectUsers): Collection
    {
        preg_match_all('/@([A-Za-z0-9._-]+)/', $body, $matches);

        $tokens = collect($matches[1] ?? [])
            ->map(fn (string $token) => strtolower(trim($token)))
            ->filter()
            ->unique()
            ->values();

        if ($tokens->isEmpty()) {
            return collect();
        }

        return $projectUsers
            ->filter(fn ($user) => $user instanceof User)
            ->filter(function (User $user) use ($tokens) {
                $normalizedName = $this->normalizeNameForMention($user->name);

                return $tokens->contains($normalizedName);
            })
            ->values();
    }

    private function normalizeNameForMention(string $name): string
    {
        $normalized = strtolower(trim($name));
        $normalized = preg_replace('/[^a-z0-9]+/', '_', $normalized) ?? $normalized;

        return trim($normalized, '_');
    }
}
