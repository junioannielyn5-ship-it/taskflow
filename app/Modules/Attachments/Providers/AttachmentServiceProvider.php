<?php

namespace App\Modules\Attachments\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Modules\Attachments\Models\TaskAttachment;
use App\Modules\Attachments\Policies\TaskAttachmentPolicy;

class AttachmentServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::policy(TaskAttachment::class, TaskAttachmentPolicy::class);
    }
}
