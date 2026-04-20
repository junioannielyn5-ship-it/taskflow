<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendBroadcastEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @param  array<int, string>  $recipients
     */
    public function __construct(
        public array $recipients,
        public string $subject,
        public string $body,
        public ?string $replyTo = null,
    ) {}

    public function handle(): void
    {
        if (empty($this->recipients)) {
            return;
        }

        Mail::raw($this->body, function ($mail) {
            $mail->to($this->recipients[0]);

            if (count($this->recipients) > 1) {
                $mail->bcc(array_slice($this->recipients, 1));
            }

            $mail->subject($this->subject);

            if (!empty($this->replyTo)) {
                $mail->replyTo($this->replyTo);
            }
        });
    }
}
