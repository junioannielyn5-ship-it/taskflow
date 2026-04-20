<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email Alerts Overview</title>
    <script>
        if (localStorage.getItem('mv-theme') === 'dark' || (!('mv-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css']); ?>
</head>
<body class="min-h-screen bg-[#f8fafc] dark:bg-slate-900 text-slate-800 dark:text-slate-200">
    <div class="mx-auto max-w-7xl px-4 py-8 md:px-6">
        <div class="mb-6 flex flex-wrap items-start justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Email Alerts Overview</h1>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Task deadline levels shown when clicking Email: Warning, Critical, Reminder, Overdue.</p>
                <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">As of <?php echo e($today->format('M d, Y')); ?></p>
            </div>
            <div class="flex gap-2">
                
                <button onclick="toggleDarkMode()" class="rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-slate-500 dark:text-amber-400 hover:bg-slate-50 dark:hover:bg-slate-600 transition-colors" title="Toggle Dark Mode">
                    <svg class="h-5 w-5 hidden dark:block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" /></svg>
                    <svg class="h-5 w-5 block dark:hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" /></svg>
                </button>
                <a href="<?php echo e(route('email.shortcut', ['send_test' => 1, 'to' => auth()->user()?->email])); ?>" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">Send Test Email</a>
                <a href="#overdue-reminder-status" class="rounded-lg border border-emerald-300 dark:border-emerald-600 bg-white dark:bg-slate-800 px-4 py-2 text-sm font-medium text-emerald-700 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-slate-700">Open Overdue Status</a>
                <a href="<?php echo e(route('dashboard')); ?>" class="rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700">Back to Dashboard</a>
            </div>
        </div>

        <?php if(session('status')): ?>
            <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="mb-4 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                <?php echo e($errors->first()); ?>

            </div>
        <?php endif; ?>

        <details id="overdue-reminder-status" open class="mb-4 rounded-xl border border-emerald-200 dark:border-emerald-800 bg-emerald-50 dark:bg-emerald-950/30 p-4">
            <summary class="cursor-pointer list-none text-sm font-semibold text-emerald-900 dark:text-emerald-300">
                <span class="inline-flex items-center gap-2">Overdue Reminder Status</span>
            </summary>
            <p class="mt-2 text-xs text-emerald-700 dark:text-emerald-400">Latest automatic overdue email reminder run details.</p>
            <div class="mt-2 grid grid-cols-1 gap-2 text-xs text-slate-700 dark:text-slate-300 md:grid-cols-2">
                <p><span class="font-semibold text-slate-900 dark:text-slate-100">Last Run:</span> <?php echo e(!empty($overdueReminderLastRunAt) ? \Carbon\Carbon::parse($overdueReminderLastRunAt)->format('M d, Y h:i A') : 'Not yet recorded'); ?></p>
                <p><span class="font-semibold text-slate-900 dark:text-slate-100">Emails Sent:</span> <?php echo e($overdueReminderLastSentCount ?? 0); ?></p>
            </div>
            <div class="mt-3 flex flex-wrap gap-2 text-xs">
                <a href="#mail-header-preview" class="rounded border border-emerald-300 dark:border-emerald-600 bg-white dark:bg-slate-800 px-3 py-1.5 font-medium text-emerald-700 dark:text-emerald-400 hover:bg-emerald-100 dark:hover:bg-slate-700">View Email Details</a>
                <?php if(isset($toPreview) && $toPreview->isNotEmpty()): ?>
                    <a href="mailto:<?php echo e($toPreview->first()); ?>" class="rounded border border-sky-300 dark:border-sky-600 bg-white dark:bg-slate-800 px-3 py-1.5 font-medium text-sky-700 dark:text-sky-400 hover:bg-sky-100 dark:hover:bg-slate-700">Open Email App</a>
                <?php endif; ?>
            </div>
        </details>

        <div id="email-overview-tabs" class="mb-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-3 shadow-sm">
            <div class="flex flex-wrap gap-2" role="tablist" aria-label="Email Overview Tabs">
                <button
                    type="button"
                    class="overview-tab-btn rounded-full border border-slate-300 bg-slate-900 px-3 py-1.5 text-xs font-semibold text-white"
                    data-overview-target="overview-panel-recipients"
                    role="tab"
                    aria-selected="true"
                >
                    Recipients and Directory
                </button>
                <button
                    type="button"
                    class="overview-tab-btn rounded-full border border-slate-300 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50"
                    data-overview-target="overview-panel-deadlines"
                    role="tab"
                    aria-selected="false"
                >
                    Deadline Levels
                </button>
            </div>
        </div>

        <div id="overview-panel-recipients" class="overview-tab-panel" role="tabpanel">

        <div id="mail-header-preview" class="mb-4 rounded-xl border border-sky-200 dark:border-sky-800 bg-sky-50 dark:bg-sky-950/30 p-4 scroll-mt-24">
            <?php
                $senderName = null;
                $senderEmail = null;
                if (!empty($fromPreview) && preg_match('/^(.*?)\s*<([^>]+)>$/', $fromPreview, $senderMatch)) {
                    $senderName = trim($senderMatch[1], ' \"');
                    $senderEmail = trim($senderMatch[2]);
                } elseif (!empty($fromPreview) && filter_var($fromPreview, FILTER_VALIDATE_EMAIL)) {
                    $senderEmail = trim($fromPreview);
                }
            ?>

            <h2 class="text-sm font-semibold text-sky-900">Mail Header Preview (Presentation View)</h2>
            <p class="mt-1 text-xs text-sky-700">This shows the exact sender and recipients used by automatic deadline alert emails.</p>

            <div class="mt-3 space-y-2">
                <div class="rounded-lg border border-sky-200 bg-white/80 px-3 py-2 text-xs text-slate-700">
                    <p class="font-semibold text-slate-900">From (Sender)</p>
                    <p class="mt-0.5 text-slate-500">This is the email account that sends the alert.</p>
                    <div class="mt-1">
                        <?php if($senderEmail): ?>
                            <?php if(!empty($senderName)): ?>
                                <span class="font-medium text-slate-800"><?php echo e($senderName); ?></span>
                                <span class="text-slate-500">&lt;</span><a href="mailto:<?php echo e($senderEmail); ?>" class="text-blue-700 underline hover:text-blue-900"><?php echo e($senderEmail); ?></a><span class="text-slate-500">&gt;</span>
                            <?php else: ?>
                                <a href="mailto:<?php echo e($senderEmail); ?>" class="text-blue-700 underline hover:text-blue-900"><?php echo e($senderEmail); ?></a>
                            <?php endif; ?>
                        <?php else: ?>
                            <span>N/A</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="rounded-lg border border-sky-200 bg-white/80 px-3 py-2 text-xs text-slate-700">
                    <p class="font-semibold text-slate-900">To (Primary Recipient)</p>
                    <p class="mt-0.5 text-slate-500">Main receiver(s) of the alert.</p>
                    <?php if(isset($toPreview) && $toPreview->isNotEmpty()): ?>
                        <div class="mt-1 inline-flex flex-wrap gap-1.5">
                            <?php $__currentLoopData = $toPreview; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $toEmail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="mailto:<?php echo e($toEmail); ?>" class="rounded-full border border-blue-200 bg-blue-50 px-2 py-0.5 text-blue-700 hover:bg-blue-100"><?php echo e($toEmail); ?></a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <p class="mt-1">N/A</p>
                    <?php endif; ?>
                </div>

                <div class="rounded-lg border border-sky-200 bg-white/80 px-3 py-2 text-xs text-slate-700">
                    <p class="font-semibold text-slate-900">CC (Visible Copy)</p>
                    <p class="mt-0.5 text-slate-500">Additional recipient(s) visible to everyone in the email thread.</p>
                    <?php if(isset($ccPreview) && $ccPreview->isNotEmpty()): ?>
                        <div class="mt-1 inline-flex flex-wrap gap-1.5">
                            <?php $__currentLoopData = $ccPreview; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ccEmail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="mailto:<?php echo e($ccEmail); ?>" class="rounded-full border border-violet-200 bg-violet-50 px-2 py-0.5 text-violet-700 hover:bg-violet-100"><?php echo e($ccEmail); ?></a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <p class="mt-1">N/A</p>
                    <?php endif; ?>
                </div>

                <div class="rounded-lg border border-sky-200 bg-white/80 px-3 py-2 text-xs text-slate-700">
                    <p class="font-semibold text-slate-900">BCC (Hidden Copy)</p>
                    <p class="mt-0.5 text-slate-500">Recipient(s) that receive a copy but are hidden from other recipients.</p>
                    <div class="mt-1">
                        <?php if(!empty($bccPreview)): ?>
                            <a href="mailto:<?php echo e($bccPreview); ?>" class="rounded-full border border-rose-200 bg-rose-50 px-2 py-0.5 text-rose-700 hover:bg-rose-100"><?php echo e($bccPreview); ?></a>
                        <?php else: ?>
                            <span>N/A</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4 rounded-xl border border-teal-200 bg-teal-50 p-4">
            <h2 class="text-sm font-semibold text-teal-900">Department Email Directory</h2>
            <p class="mt-1 text-xs text-teal-700">Official contacts per team: Pre-Sales, Sales, Technical, Admin Support.</p>

            <?php if(isset($departmentEmailDirectory) && collect($departmentEmailDirectory)->isNotEmpty()): ?>
                <div id="department-email-tabs" class="mt-3">
                    <div class="mb-3 flex flex-wrap gap-2" role="tablist" aria-label="Department Email Tabs">
                        <?php $__currentLoopData = $departmentEmailDirectory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button
                                type="button"
                                class="department-tab-btn rounded-full border px-3 py-1.5 text-xs font-semibold transition <?php echo e($index === 0 ? 'border-teal-300 bg-white text-teal-800' : 'border-teal-200 bg-teal-100 text-teal-700 hover:bg-white'); ?>"
                                data-tab-target="department-panel-<?php echo e($index); ?>"
                                role="tab"
                                aria-selected="<?php echo e($index === 0 ? 'true' : 'false'); ?>"
                            >
                                <?php echo e($group['department']); ?>

                            </button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <?php $__currentLoopData = $departmentEmailDirectory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div
                            id="department-panel-<?php echo e($index); ?>"
                            class="department-tab-panel rounded-lg border border-teal-200 bg-white/80 p-3 text-xs text-slate-700 <?php echo e($index === 0 ? '' : 'hidden'); ?>"
                            role="tabpanel"
                        >
                            <p class="font-semibold text-slate-900"><?php echo e($group['department']); ?></p>
                            <div class="mt-2 space-y-1.5">
                                <?php $__currentLoopData = ($group['members'] ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex flex-wrap items-center gap-1.5">
                                        <span class="font-medium text-slate-800"><?php echo e($member['name']); ?></span>
                                        <?php if(!empty($member['email'])): ?>
                                            <span class="text-slate-500">-</span>
                                            <a href="mailto:<?php echo e($member['email']); ?>" class="rounded-full border border-teal-200 bg-teal-100 px-2 py-0.5 text-teal-800 hover:bg-teal-200"><?php echo e($member['email']); ?></a>
                                        <?php else: ?>
                                            <span class="text-slate-400">- No email set</span>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <p class="mt-2 text-xs text-slate-500">No department email directory available yet.</p>
            <?php endif; ?>
        </div>

        </div>

        <div id="overview-panel-deadlines" class="overview-tab-panel hidden" role="tabpanel">

        <div class="mb-4 rounded-xl border border-indigo-200 bg-indigo-50 p-4">
            <h2 class="text-sm font-semibold text-indigo-900">Example Email Alerts (Preview)</h2>
            <p class="mt-1 text-xs text-indigo-700">This is the sample format of automatic email alerts so you can see what to expect per level.</p>
            <div class="mt-3 grid grid-cols-1 gap-2 md:grid-cols-2">
                <div class="rounded-lg border border-amber-200 bg-white px-3 py-2 text-xs text-slate-700">
                    <p class="font-semibold text-amber-700">WARNING</p>
                    <p>Task "Prepare Monthly Report" is due in 7 days.</p>
                </div>
                <div class="rounded-lg border border-orange-200 bg-white px-3 py-2 text-xs text-slate-700">
                    <p class="font-semibold text-orange-700">CRITICAL</p>
                    <p>Task "Client Proposal Final" is due in 3 days.</p>
                </div>
                <div class="rounded-lg border border-blue-200 bg-white px-3 py-2 text-xs text-slate-700">
                    <p class="font-semibold text-blue-700">REMINDER</p>
                    <p>Task "Submit Q1 KPIs" is due today.</p>
                </div>
                <div class="rounded-lg border border-rose-200 bg-white px-3 py-2 text-xs text-slate-700">
                    <p class="font-semibold text-rose-700">OVERDUE</p>
                    <p>Task "Vendor Contract Review" has passed its deadline.</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
            <a href="#warning-section" class="rounded-xl border border-amber-200 bg-amber-50 p-4 transition hover:-translate-y-0.5 hover:shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wide text-amber-700">Warning</p>
                <p class="mt-2 text-2xl font-bold text-amber-800"><?php echo e($warningTasks->count()); ?></p>
                <p class="mt-1 text-xs text-amber-700">Due in 7 days</p>
            </a>
            <a href="#critical-section" class="rounded-xl border border-orange-200 bg-orange-50 p-4 transition hover:-translate-y-0.5 hover:shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wide text-orange-700">Critical</p>
                <p class="mt-2 text-2xl font-bold text-orange-800"><?php echo e($criticalTasks->count()); ?></p>
                <p class="mt-1 text-xs text-orange-700">Due in 3 days</p>
            </a>
            <a href="#reminder-section" class="rounded-xl border border-blue-200 bg-blue-50 p-4 transition hover:-translate-y-0.5 hover:shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wide text-blue-700">Reminder</p>
                <p class="mt-2 text-2xl font-bold text-blue-800"><?php echo e($reminderTasks->count()); ?></p>
                <p class="mt-1 text-xs text-blue-700">Due today</p>
            </a>
            <a href="#overdue-section" class="rounded-xl border border-rose-200 bg-rose-50 p-4 transition hover:-translate-y-0.5 hover:shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wide text-rose-700">Overdue</p>
                <p class="mt-2 text-2xl font-bold text-rose-800"><?php echo e($overdueTasks->count()); ?></p>
                <p class="mt-1 text-xs text-rose-700">Past deadline</p>
            </a>
        </div>

        <?php
            $sections = [
                'warning' => ['label' => 'Warning (7 Days)', 'tasks' => $warningTasks, 'badge' => 'bg-amber-100 text-amber-700', 'row' => 'bg-amber-50/50'],
                'critical' => ['label' => 'Critical (3 Days)', 'tasks' => $criticalTasks, 'badge' => 'bg-orange-100 text-orange-700', 'row' => 'bg-orange-50/50'],
                'reminder' => ['label' => 'Reminder (Today)', 'tasks' => $reminderTasks, 'badge' => 'bg-blue-100 text-blue-700', 'row' => 'bg-blue-50/50'],
                'overdue' => ['label' => 'Overdue', 'tasks' => $overdueTasks, 'badge' => 'bg-rose-100 text-rose-700', 'row' => 'bg-rose-50/50'],
            ];
        ?>

        <div class="mt-6 grid grid-cols-1 gap-4 xl:grid-cols-2">
            <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $config): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div id="<?php echo e($key); ?>-section" class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm scroll-mt-24">
                    <div class="mb-3 flex items-center justify-between">
                        <h2 class="text-sm font-semibold text-slate-800"><?php echo e($config['label']); ?></h2>
                        <span class="rounded-full px-2 py-1 text-xs font-semibold <?php echo e($config['badge']); ?>"><?php echo e($config['tasks']->count()); ?> task(s)</span>
                    </div>

                    <?php if($config['tasks']->isEmpty()): ?>
                        <p class="rounded-lg border border-dashed border-slate-200 bg-slate-50 px-3 py-5 text-center text-sm text-slate-500">No tasks in this level.</p>
                    <?php else: ?>
                        <div class="space-y-2">
                            <?php $__currentLoopData = $config['tasks']->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('tasks.show', $task)); ?>" class="block rounded-lg border border-slate-200 px-3 py-2 text-sm hover:bg-slate-50 <?php echo e($config['row']); ?>">
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="font-medium text-slate-800"><?php echo e($task->title); ?></p>
                                        <span class="text-xs text-slate-500"><?php echo e(optional($task->due_date)->format('M d, Y')); ?></span>
                                    </div>
                                    <p class="mt-1 text-xs text-slate-500">Project: <?php echo e($task->project->name ?? 'N/A'); ?></p>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const overviewTabs = document.getElementById('email-overview-tabs');
            if (overviewTabs) {
                const overviewButtons = overviewTabs.querySelectorAll('.overview-tab-btn');
                const overviewPanels = document.querySelectorAll('.overview-tab-panel');

                overviewButtons.forEach((button) => {
                    button.addEventListener('click', function () {
                        const targetId = button.getAttribute('data-overview-target');

                        overviewButtons.forEach((btn) => {
                            btn.classList.remove('bg-slate-900', 'text-white');
                            btn.classList.add('bg-white', 'text-slate-700');
                            btn.setAttribute('aria-selected', 'false');
                        });

                        overviewPanels.forEach((panel) => {
                            panel.classList.add('hidden');
                        });

                        button.classList.remove('bg-white', 'text-slate-700');
                        button.classList.add('bg-slate-900', 'text-white');
                        button.setAttribute('aria-selected', 'true');

                        const targetPanel = document.getElementById(targetId);
                        if (targetPanel) {
                            targetPanel.classList.remove('hidden');
                        }
                    });
                });
            }

            const departmentTabs = document.getElementById('department-email-tabs');
            if (departmentTabs) {
                const buttons = departmentTabs.querySelectorAll('.department-tab-btn');
                const panels = departmentTabs.querySelectorAll('.department-tab-panel');

                buttons.forEach((button) => {
                    button.addEventListener('click', function () {
                        const targetId = button.getAttribute('data-tab-target');

                        buttons.forEach((btn) => {
                            btn.classList.remove('border-teal-300', 'bg-white', 'text-teal-800');
                            btn.classList.add('border-teal-200', 'bg-teal-100', 'text-teal-700');
                            btn.setAttribute('aria-selected', 'false');
                        });

                        panels.forEach((panel) => {
                            panel.classList.add('hidden');
                        });

                        button.classList.remove('border-teal-200', 'bg-teal-100', 'text-teal-700');
                        button.classList.add('border-teal-300', 'bg-white', 'text-teal-800');
                        button.setAttribute('aria-selected', 'true');

                        const targetPanel = departmentTabs.querySelector('#' + targetId);
                        if (targetPanel) {
                            targetPanel.classList.remove('hidden');
                        }
                    });
                });
            }
        });
    </script>

    <script>
    function toggleDarkMode() {
        var html = document.documentElement;
        html.classList.toggle('dark');
        if (html.classList.contains('dark')) {
            localStorage.setItem('mv-theme', 'dark');
        } else {
            localStorage.setItem('mv-theme', 'light');
        }
    }
    </script>
</body>
</html>
<?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views/emails/deadline-levels.blade.php ENDPATH**/ ?>