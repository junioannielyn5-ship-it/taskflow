<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <section class="relative overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-6 shadow-sm">
        <div class="pointer-events-none absolute -bottom-16 -right-14 h-48 w-48 rounded-full bg-emerald-200/40 dark:bg-emerald-900/20 blur-3xl"></div>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Project Manager</h1>
        <p class="mt-2 max-w-2xl text-sm text-slate-600 dark:text-slate-400">Coordinate execution from kickoff to release with visibility into scope, timeline, and delivery confidence.</p>
        <div class="mt-5 flex flex-wrap gap-2 text-xs font-semibold">
            <span class="rounded-full border border-emerald-200 dark:border-emerald-800 bg-emerald-50 dark:bg-emerald-900/30 px-3 py-1 text-emerald-700 dark:text-emerald-400">Milestones</span>
            <span class="rounded-full border border-cyan-200 dark:border-cyan-800 bg-cyan-50 dark:bg-cyan-900/30 px-3 py-1 text-cyan-700 dark:text-cyan-400">Workload</span>
            <span class="rounded-full border border-indigo-200 dark:border-indigo-800 bg-indigo-50 dark:bg-indigo-900/30 px-3 py-1 text-indigo-700 dark:text-indigo-400">Delivery Signals</span>
        </div>
    </section>

    <section class="grid gap-4 md:grid-cols-3">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-project')): ?>
            <a href="<?php echo e(route('projects.create')); ?>" class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-300 dark:hover:border-emerald-600 hover:shadow-md">
                <div class="text-xs font-semibold uppercase tracking-wide text-emerald-700 dark:text-emerald-400">Project Setup</div>
                <div class="mt-2 text-lg font-semibold text-slate-900 dark:text-white">Create Project</div>
                <div class="mt-1 text-sm text-slate-600 dark:text-slate-400">Configure goals, dates, members, and governance.</div>
            </a>
        <?php endif; ?>

        <a href="<?php echo e(route('tasks.list')); ?>" class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-300 dark:hover:border-emerald-600 hover:shadow-md">
            <div class="text-xs font-semibold uppercase tracking-wide text-emerald-700 dark:text-emerald-400">Execution</div>
            <div class="mt-2 text-lg font-semibold text-slate-900 dark:text-white">Team Tasks</div>
            <div class="mt-1 text-sm text-slate-600 dark:text-slate-400">Monitor priorities, dependencies, and progress in real time.</div>
        </a>

        <a href="<?php echo e(route('reports.index')); ?>" class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-300 dark:hover:border-emerald-600 hover:shadow-md">
            <div class="text-xs font-semibold uppercase tracking-wide text-emerald-700 dark:text-emerald-400">Insights</div>
            <div class="mt-2 text-lg font-semibold text-slate-900 dark:text-white">Reporting</div>
            <div class="mt-1 text-sm text-slate-600 dark:text-slate-400">Review completion, lead time, and delivery consistency.</div>
        </a>
    </section>

    <section class="grid gap-4 md:grid-cols-2">
        <a href="<?php echo e(route('meetings.index')); ?>" class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-gradient-to-br from-white to-emerald-50 dark:from-slate-800 dark:to-emerald-900/10 p-5 shadow-sm transition hover:border-emerald-300 dark:hover:border-emerald-600">
            <div class="text-sm font-semibold text-slate-900 dark:text-white">Meetings</div>
            <div class="mt-1 text-sm text-slate-600 dark:text-slate-400">Run standups and checkpoint meetings with clear agendas.</div>
        </a>
        <a href="<?php echo e(route('holidays.index')); ?>" class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-gradient-to-br from-white to-cyan-50 dark:from-slate-800 dark:to-cyan-900/10 p-5 shadow-sm transition hover:border-cyan-300 dark:hover:border-cyan-600">
            <div class="text-sm font-semibold text-slate-900 dark:text-white">Holidays</div>
            <div class="mt-1 text-sm text-slate-600 dark:text-slate-400">Adjust timelines around non-working days and leave windows.</div>
        </a>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views\project-manager\index.blade.php ENDPATH**/ ?>