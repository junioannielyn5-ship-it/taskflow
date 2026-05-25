<?php
    $inline = $inline ?? false;
    $user = auth()->user();
    $canViewReports = $user && method_exists($user, 'hasAnyRole') && $user->hasAnyRole(['admin', 'manager', 'project_manager', 'pm', 'lead', 'executive']);
    $canViewManager = $user && method_exists($user, 'hasAnyRole') && $user->hasAnyRole(['manager', 'executive', 'admin']);
    $canViewProjectManager = $user && method_exists($user, 'hasAnyRole') && $user->hasAnyRole(['project_manager', 'pm', 'admin']);
    $canViewExecutive = $user && method_exists($user, 'hasAnyRole') && $user->hasAnyRole(['executive', 'admin']);
    $canViewLead = $user && method_exists($user, 'hasAnyRole') && $user->hasAnyRole(['lead', 'admin']);
    $linkBase = 'mv-nav-pill';
    $linkClass = static function (array $patterns) use ($linkBase): string {
        foreach ($patterns as $pattern) {
            if (request()->routeIs($pattern)) {
                return $linkBase.' mv-nav-pill-active';
            }
        }

        return $linkBase;
    };
?>

<div class="<?php echo e($inline ? 'flex flex-wrap items-center gap-2' : 'flex flex-wrap items-center gap-2'); ?>">
    <a href="/dashboard" class="<?php echo e($linkClass(['dashboard'])); ?>">Dashboard</a>
    <a href="<?php echo e(route('tasks.list')); ?>" class="<?php echo e($linkClass(['tasks.*'])); ?>">Tasks</a>
    <a href="<?php echo e(route('tasks.kanban')); ?>" class="<?php echo e($linkClass(['tasks.kanban'])); ?>">Kanban</a>
    <a href="<?php echo e(route('tasks.calendar')); ?>" class="<?php echo e($linkClass(['tasks.calendar'])); ?>">Calendar</a>
    <a href="<?php echo e(route('meetings.index')); ?>" class="<?php echo e($linkClass(['meetings.*'])); ?>">Meetings</a>
    <a href="<?php echo e(route('holidays.index')); ?>" class="<?php echo e($linkClass(['holidays.*'])); ?>">Holidays</a>
    <a href="<?php echo e(route('email.shortcut')); ?>" class="<?php echo e($linkClass(['email.*', 'notifications.*'])); ?>">Email Alerts</a>
    <a href="<?php echo e(route('admin.chatbot.index')); ?>" class="<?php echo e($linkClass(['admin.chatbot.*'])); ?>">Chatbot</a>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-task')): ?>
        <a href="<?php echo e(route('tasks.create')); ?>" class="<?php echo e($linkClass(['tasks.create'])); ?>">Create Task</a>
    <?php endif; ?>

    <a href="/projects" class="<?php echo e($linkClass(['projects.*'])); ?>">Projects</a>

    <?php if($canViewReports): ?>
        <a href="/reports" class="<?php echo e($linkClass(['reports.*'])); ?>">Reports</a>
    <?php endif; ?>

    <?php if($user && method_exists($user, 'hasAnyRole') && $user->hasAnyRole(['member', 'employee', 'technical'])): ?>
        <a href="<?php echo e(route('employee.index')); ?>" class="<?php echo e($linkClass(['employee.*'])); ?>">Employee</a>
    <?php endif; ?>

    <?php if($canViewManager): ?>
        <a href="<?php echo e(route('manager.index')); ?>" class="<?php echo e($linkClass(['manager.*'])); ?>">Manager</a>
    <?php endif; ?>

    <?php if($canViewProjectManager): ?>
        <a href="<?php echo e(route('project-manager.index')); ?>" class="<?php echo e($linkClass(['project-manager.*'])); ?>">Project Manager</a>
    <?php endif; ?>

    <?php if($canViewExecutive): ?>
        <a href="<?php echo e(route('executive.index')); ?>" class="<?php echo e($linkClass(['executive.*'])); ?>">Executive</a>
    <?php endif; ?>

    <?php if($canViewLead): ?>
        <a href="<?php echo e(route('lead.index')); ?>" class="<?php echo e($linkClass(['lead.*'])); ?>">Lead</a>
    <?php endif; ?>

    <?php if($user && method_exists($user, 'isAdmin') && $user->isAdmin()): ?>
        <a href="/admin" class="<?php echo e($linkClass(['admin.*'])); ?>">Admin</a>
    <?php endif; ?>

    <?php if(Route::has('logout')): ?>
        <form method="POST" action="<?php echo e(route('logout')); ?>" class="inline-flex">
            <?php echo csrf_field(); ?>
            <button type="submit" class="<?php echo e($linkBase); ?> mv-nav-danger">Logout</button>
        </form>
    <?php endif; ?>
</div>
<?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views\partials\role-nav.blade.php ENDPATH**/ ?>