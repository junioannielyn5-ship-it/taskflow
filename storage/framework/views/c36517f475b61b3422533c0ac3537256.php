<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <section class="relative overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-6 shadow-sm">
        <div class="pointer-events-none absolute -top-20 right-8 h-48 w-48 rounded-full bg-indigo-200/40 dark:bg-indigo-500/10 blur-3xl"></div>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Executive Insights Center</h1>
        <p class="mt-2 max-w-2xl text-sm text-slate-600 dark:text-slate-400">Track delivery confidence, portfolio performance, and strategic execution from a single command view.</p>
        <div class="mt-5 flex flex-wrap gap-2 text-xs font-semibold">
            <span class="rounded-full border border-indigo-200 dark:border-indigo-700 bg-indigo-50 dark:bg-indigo-900/30 px-3 py-1 text-indigo-700 dark:text-indigo-400">KPI Visibility</span>
            <span class="rounded-full border border-cyan-200 dark:border-cyan-700 bg-cyan-50 dark:bg-cyan-900/30 px-3 py-1 text-cyan-700 dark:text-cyan-400">Strategic Reports</span>
            <span class="rounded-full border border-rose-200 dark:border-rose-700 bg-rose-50 dark:bg-rose-900/30 px-3 py-1 text-rose-700 dark:text-rose-400">Risk Signals</span>
        </div>
    </section>

    <section class="grid gap-4 md:grid-cols-3">
        <a href="<?php echo e(route('dashboard')); ?>" class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-indigo-300 dark:hover:border-indigo-500 hover:shadow-md dark:hover:shadow-[0_4px_20px_rgba(99,102,241,0.15)]">
            <div class="text-xs font-semibold uppercase tracking-wide text-indigo-700 dark:text-indigo-400">Overview</div>
            <div class="mt-2 text-lg font-semibold text-slate-900 dark:text-slate-100">Executive Dashboard</div>
            <div class="mt-1 text-sm text-slate-600 dark:text-slate-400">Monitor organization-wide outcomes and current momentum.</div>
        </a>

        <a href="<?php echo e(route('reports.index')); ?>" class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-indigo-300 dark:hover:border-indigo-500 hover:shadow-md dark:hover:shadow-[0_4px_20px_rgba(99,102,241,0.15)]">
            <div class="text-xs font-semibold uppercase tracking-wide text-indigo-700 dark:text-indigo-400">Analytics</div>
            <div class="mt-2 text-lg font-semibold text-slate-900 dark:text-slate-100">Reports</div>
            <div class="mt-1 text-sm text-slate-600 dark:text-slate-400">Open strategic reporting for teams, projects, and delivery quality.</div>
        </a>

        <a href="<?php echo e(route('tasks.list')); ?>" class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-indigo-300 dark:hover:border-indigo-500 hover:shadow-md dark:hover:shadow-[0_4px_20px_rgba(99,102,241,0.15)]">
            <div class="text-xs font-semibold uppercase tracking-wide text-indigo-700 dark:text-indigo-400">Operations</div>
            <div class="mt-2 text-lg font-semibold text-slate-900 dark:text-slate-100">Task Snapshot</div>
            <div class="mt-1 text-sm text-slate-600 dark:text-slate-400">Inspect cross-team workload and outstanding commitments.</div>
        </a>
    </section>

    <section class="grid gap-4 md:grid-cols-2">
        <a href="<?php echo e(route('projects.index')); ?>" class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-gradient-to-br from-white to-indigo-50 dark:from-slate-800 dark:to-indigo-900/20 p-5 shadow-sm transition hover:border-indigo-300 dark:hover:border-indigo-500 hover:shadow-md dark:hover:shadow-[0_4px_20px_rgba(99,102,241,0.1)]">
            <div class="text-sm font-semibold text-slate-900 dark:text-slate-100">Project Portfolio</div>
            <div class="mt-1 text-sm text-slate-600 dark:text-slate-400">Review active initiatives and project completion health.</div>
        </a>
        <a href="<?php echo e(route('notifications.history')); ?>" class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-gradient-to-br from-white to-rose-50 dark:from-slate-800 dark:to-rose-900/20 p-5 shadow-sm transition hover:border-rose-300 dark:hover:border-rose-500 hover:shadow-md dark:hover:shadow-[0_4px_20px_rgba(244,63,94,0.1)]">
            <div class="text-sm font-semibold text-slate-900 dark:text-slate-100">Email Alerts</div>
            <div class="mt-1 text-sm text-slate-600 dark:text-slate-400">Stay informed on escalations, deadlines, and critical updates.</div>
        </a>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views\executive\index.blade.php ENDPATH**/ ?>