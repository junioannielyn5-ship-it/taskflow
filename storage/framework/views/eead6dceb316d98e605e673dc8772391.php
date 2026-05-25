<?php $__env->startSection('content'); ?>
<div class="relative overflow-hidden bg-gradient-to-br from-violet-50 via-white to-fuchsia-50 dark:from-slate-900 dark:via-slate-900 dark:to-slate-800 py-8 min-h-screen">
    <div class="pointer-events-none absolute -top-24 -left-24 h-56 w-56 rounded-full bg-violet-300/30 dark:bg-violet-900/20 blur-3xl"></div>
    <div class="pointer-events-none absolute top-0 right-1/4 h-44 w-44 rounded-full bg-fuchsia-300/25 dark:bg-fuchsia-900/20 blur-3xl"></div>
    <div class="pointer-events-none absolute right-0 bottom-0 h-72 w-72 rounded-full bg-indigo-300/25 dark:bg-indigo-900/20 blur-3xl"></div>

    <div class="container relative mx-auto space-y-6 px-6">
        <div class="rounded-3xl border border-violet-100 dark:border-white/10 bg-white/90 dark:bg-slate-900/60 p-6 shadow-xl ring-1 ring-violet-100/70 dark:ring-white/5 backdrop-blur md:p-8">
            <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="text-xs font-semibold tracking-[0.2em] text-violet-700 dark:text-violet-400 uppercase">Administration</p>
                    <h1 class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">Movaflex Control Center</h1>
                    <p class="mt-2 max-w-2xl text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                        Manage governance, reporting access, and configuration from one secure admin workspace.
                    </p>
                </div>
                <a
                    href="<?php echo e(route('dashboard')); ?>"
                    class="inline-flex items-center justify-center rounded-xl border border-slate-300 dark:border-white/20 px-4 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 transition hover:bg-slate-50 dark:hover:bg-white/5"
                >
                    Return to Dashboard
                </a>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-2xl border border-violet-200 dark:border-violet-900/50 bg-gradient-to-br from-violet-50 to-indigo-100 dark:from-violet-900/20 dark:to-indigo-900/20 p-4 shadow-sm">
                <p class="text-xs font-semibold tracking-wide text-violet-700 dark:text-violet-400 uppercase">Scope</p>
                <p class="mt-1 text-xl font-bold text-violet-900 dark:text-violet-100">System Admin</p>
                <p class="mt-1 text-sm text-violet-800/80 dark:text-violet-200/70">Platform-wide access and policy enforcement.</p>
            </div>
            <div class="rounded-2xl border border-fuchsia-200 dark:border-fuchsia-900/50 bg-gradient-to-br from-fuchsia-50 to-violet-100 dark:from-fuchsia-900/20 dark:to-violet-900/20 p-4 shadow-sm">
                <p class="text-xs font-semibold tracking-wide text-fuchsia-700 dark:text-fuchsia-400 uppercase">Data</p>
                <p class="mt-1 text-xl font-bold text-fuchsia-900 dark:text-fuchsia-100">Live Operations</p>
                <p class="mt-1 text-sm text-fuchsia-800/80 dark:text-fuchsia-200/70">Configuration and task/reporting modules are active.</p>
            </div>
            <div class="rounded-2xl border border-indigo-200 dark:border-indigo-900/50 bg-gradient-to-br from-indigo-50 to-violet-100 dark:from-indigo-900/20 dark:to-violet-900/20 p-4 shadow-sm">
                <p class="text-xs font-semibold tracking-wide text-indigo-700 dark:text-indigo-400 uppercase">Broadcast</p>
                <p class="mt-1 text-xl font-bold text-indigo-900 dark:text-indigo-100">Comms Enabled</p>
                <p class="mt-1 text-sm text-indigo-800/80 dark:text-indigo-200/70">Announcement email tools are available in configuration.</p>
            </div>
        </div>

        <div class="grid gap-4 lg:grid-cols-4">
            <a
                href="<?php echo e(route('admin.config.index')); ?>"
                class="group rounded-2xl border border-violet-100 dark:border-white/10 bg-gradient-to-br from-white to-violet-50 dark:from-slate-800 dark:to-slate-900 p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg hover:border-violet-300 dark:hover:border-violet-500/50"
            >
                <p class="text-xs font-semibold tracking-wide text-violet-700 dark:text-violet-400 uppercase">Primary</p>
                <h2 class="mt-2 text-lg font-bold text-slate-900 dark:text-white">Configuration Hub</h2>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                    Manage company clients, task labels, team labels, announcement text, and broadcast email settings.
                </p>
                <p class="mt-4 text-sm font-semibold text-violet-700 dark:text-violet-400 group-hover:underline">Open configuration</p>
            </a>

            <a
                href="<?php echo e(route('reports.index')); ?>"
                class="group rounded-2xl border border-fuchsia-100 dark:border-white/10 bg-gradient-to-br from-white to-fuchsia-50 dark:from-slate-800 dark:to-slate-900 p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg hover:border-fuchsia-300 dark:hover:border-fuchsia-500/50"
            >
                <p class="text-xs font-semibold tracking-wide text-fuchsia-700 dark:text-fuchsia-400 uppercase">Analytics</p>
                <h2 class="mt-2 text-lg font-bold text-slate-900 dark:text-white">Reports Center</h2>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                    Review overdue workloads, completion trends, and cycle-time metrics for leadership decisions.
                </p>
                <p class="mt-4 text-sm font-semibold text-fuchsia-700 dark:text-fuchsia-400 group-hover:underline">View reports</p>
            </a>

            <a
                href="<?php echo e(route('tasks.list')); ?>"
                class="group rounded-2xl border border-indigo-100 dark:border-white/10 bg-gradient-to-br from-white to-indigo-50 dark:from-slate-800 dark:to-slate-900 p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg hover:border-indigo-300 dark:hover:border-indigo-500/50"
            >
                <p class="text-xs font-semibold tracking-wide text-indigo-700 dark:text-indigo-400 uppercase">Operations</p>
                <h2 class="mt-2 text-lg font-bold text-slate-900 dark:text-white">Task Board</h2>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                    Jump directly to active tasks, pending review queue, and overdue execution follow-ups.
                </p>
                <p class="mt-4 text-sm font-semibold text-indigo-700 dark:text-indigo-400 group-hover:underline">Open task board</p>
            </a>

            <a
                href="<?php echo e(route('admin.chatbot.index')); ?>"
                class="group rounded-2xl border border-emerald-100 dark:border-white/10 bg-gradient-to-br from-white to-emerald-50 dark:from-slate-800 dark:to-slate-900 p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg hover:border-emerald-300 dark:hover:border-emerald-500/50"
            >
                <p class="text-xs font-semibold tracking-wide text-emerald-700 dark:text-emerald-400 uppercase">Assistant</p>
                <h2 class="mt-2 text-lg font-bold text-slate-900 dark:text-white">Chatbot Knowledge</h2>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                    Add or update English and Filipino chatbot answers, steps, and quick links from the admin panel.
                </p>
                <p class="mt-4 text-sm font-semibold text-emerald-700 dark:text-emerald-400 group-hover:underline">Manage knowledge base</p>
            </a>
        </div>

        <div class="rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/50 p-6 shadow-sm">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Admin Notes</h3>
            <ul class="mt-3 space-y-2 text-sm text-slate-600 dark:text-slate-400">
                <li>- Use Configuration Hub for dropdown and announcement updates.</li>
                <li>- Use Reports Center before sending executive updates.</li>
                <li>- Use Task Board for urgent intervention and overdue follow-up.</li>
                <li>- Use Chatbot Knowledge to keep assistant guidance accurate.</li>
            </ul>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views\admin\index.blade.php ENDPATH**/ ?>