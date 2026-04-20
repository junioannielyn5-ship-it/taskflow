<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\PermissionServiceProvider::class,
    App\Providers\FortifyServiceProvider::class,
    App\Modules\Identity\Providers\IdentityServiceProvider::class,
    App\Modules\Projects\Providers\ProjectServiceProvider::class,
    App\Modules\Tasks\Providers\TaskServiceProvider::class,
    App\Modules\Workflow\Providers\WorkflowServiceProvider::class,
    App\Modules\Automation\Providers\AutomationServiceProvider::class,
    App\Modules\Comments\Providers\CommentsServiceProvider::class,
    App\Modules\Attachments\Providers\AttachmentsServiceProvider::class,
    App\Modules\Notifications\Providers\NotificationsServiceProvider::class,
    App\Modules\Reporting\Providers\ReportingServiceProvider::class,
    App\Modules\Admin\Providers\AdminServiceProvider::class,
];
