
<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-slate-100 dark:bg-slate-900 px-4 py-8 md:px-10">

    
    <div class="mb-8 rounded-3xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-6 shadow-md">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-500 shadow-lg">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div class="flex-1">
                <h1 class="text-2xl font-black text-slate-800 dark:text-white">TaskFlow User Manual</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Follow the guide in order: Login, Dashboard, Projects, Tasks, and the rest of the workflow.</p>
            </div>
            <a href="<?php echo e(route('help.pdf')); ?>" class="flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-bold text-white shadow-md hover:bg-blue-700 transition">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Download PDF
            </a>
        </div>
    </div>

    
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">

        
        <div onclick="mvHelp('login')" style="order: 1;" class="help-card cursor-pointer rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
            <div class="mb-3 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m-6-3h11.25m0 0l-3-3m3 3l-3 3"/></svg>
                </div>
                <h2 class="font-bold text-slate-800 dark:text-white">Login Page</h2>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">Start here. Sign in with your company account to access the dashboard, projects, tasks, and role-based menus.</p>
            <span class="mt-3 inline-block text-xs font-semibold text-slate-600 dark:text-slate-300">Click to learn more →</span>
        </div>

        
        <div onclick="mvHelp('dashboard')" style="order: 2;" class="help-card cursor-pointer rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
            <div class="mb-3 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                </div>
                <h2 class="font-bold text-slate-800 dark:text-white">Dashboard</h2>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">Your home screen. See all your tasks, projects, charts, and notifications at a glance.</p>
            <span class="mt-3 inline-block text-xs font-semibold text-blue-500">Click to learn more →</span>
        </div>

        
        <div onclick="mvHelp('tasks')" style="order: 4;" class="help-card cursor-pointer rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
            <div class="mb-3 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-100 dark:bg-purple-900/40 text-purple-600 dark:text-purple-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                </div>
                <h2 class="font-bold text-slate-800 dark:text-white">My Tasks</h2>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">View, filter, and manage all tasks assigned to you. Update status, add comments, and track progress.</p>
            <span class="mt-3 inline-block text-xs font-semibold text-purple-500">Click to learn more →</span>
        </div>

        
        <div onclick="mvHelp('kanban')" style="order: 5;" class="help-card cursor-pointer rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
            <div class="mb-3 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-teal-100 dark:bg-teal-900/40 text-teal-600 dark:text-teal-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/></svg>
                </div>
                <h2 class="font-bold text-slate-800 dark:text-white">Kanban Board</h2>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">Drag and drop tasks across columns: To Do, In Progress, For Review, and Done.</p>
            <span class="mt-3 inline-block text-xs font-semibold text-teal-500">Click to learn more →</span>
        </div>

        
        <div onclick="mvHelp('calendar')" style="order: 6;" class="help-card cursor-pointer rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
            <div class="mb-3 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-cyan-100 dark:bg-cyan-900/40 text-cyan-600 dark:text-cyan-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h2 class="font-bold text-slate-800 dark:text-white">Calendar</h2>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">Monthly view of tasks, meetings, and holidays. Filter by Sales or Technical team activity.</p>
            <span class="mt-3 inline-block text-xs font-semibold text-cyan-500">Click to learn more →</span>
        </div>

        
        <div onclick="mvHelp('projects')" style="order: 3;" class="help-card cursor-pointer rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
            <div class="mb-3 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h2 class="font-bold text-slate-800 dark:text-white">Projects</h2>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">Create and manage projects. Add members, assign tasks, and track overall project progress.</p>
            <span class="mt-3 inline-block text-xs font-semibold text-indigo-500">Click to learn more →</span>
        </div>

        
        <div onclick="mvHelp('meetings')" style="order: 7;" class="help-card cursor-pointer rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
            <div class="mb-3 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-100 dark:bg-violet-900/40 text-violet-600 dark:text-violet-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                </div>
                <h2 class="font-bold text-slate-800 dark:text-white">Meetings</h2>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">Schedule and view company meetings. Meetings appear on the Calendar automatically.</p>
            <span class="mt-3 inline-block text-xs font-semibold text-violet-500">Click to learn more →</span>
        </div>

        
        <div onclick="mvHelp('notifications')" style="order: 8;" class="help-card cursor-pointer rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
            <div class="mb-3 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-rose-100 dark:bg-rose-900/40 text-rose-600 dark:text-rose-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
                <h2 class="font-bold text-slate-800 dark:text-white">Notifications</h2>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">Get real-time alerts when tasks are assigned, updated, or overdue. Mark as read individually or all at once.</p>
            <span class="mt-3 inline-block text-xs font-semibold text-rose-500">Click to learn more →</span>
        </div>

        
        <div onclick="mvHelp('status')" style="order: 9;" class="help-card cursor-pointer rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
            <div class="mb-3 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h2 class="font-bold text-slate-800 dark:text-white">Task Status Guide</h2>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">Understand what each task status means: Todo, In Progress, For Review, Done, and Overdue.</p>
            <span class="mt-3 inline-block text-xs font-semibold text-amber-500">Click to learn more →</span>
        </div>

        
        <div onclick="mvHelp('roles')" style="order: 10;" class="help-card cursor-pointer rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
            <div class="mb-3 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <h2 class="font-bold text-slate-800 dark:text-white">User Roles</h2>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">Learn the difference between Executive, Project Manager, Admin, Sales, Technical, and Pre Sale roles.</p>
            <span class="mt-3 inline-block text-xs font-semibold text-emerald-500">Click to learn more →</span>
        </div>

        
        <div onclick="mvHelp('technical_role')" style="order: 17;" class="help-card cursor-pointer rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
            <div class="mb-3 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-100 dark:bg-sky-900/40 text-sky-600 dark:text-sky-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-2.16l-2.09-1.04a1 1 0 01-.527-.884V9.656a1 1 0 01.44-.832l1.238-.826a2 2 0 00.67-2.548l-.73-1.46a2 2 0 00-2.53-.89l-1.39.557a1 1 0 01-.738 0l-1.39-.557a2 2 0 00-2.53.89l-.73 1.46a2 2 0 00.67 2.548l1.238.826a1 1 0 01.44.832v1.688a1 1 0 01-.527.884l-2.09 1.04a2 2 0 00-1.022 2.16l.25 1.25a2 2 0 001.97 1.572h9.216a2 2 0 001.97-1.572l.25-1.25z"/></svg>
                </div>
                <h2 class="font-bold text-slate-800 dark:text-white">Technical Role Guide</h2>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">Detailed guide for technical delivery, fixes, testing, and task completion flow.</p>
            <span class="mt-3 inline-block text-xs font-semibold text-sky-500">Click to learn more →</span>
        </div>

        
        <div onclick="mvHelp('sales_role')" style="order: 18;" class="help-card cursor-pointer rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
            <div class="mb-3 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-pink-100 dark:bg-pink-900/40 text-pink-600 dark:text-pink-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9 6 9-6M5 5h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"/></svg>
                </div>
                <h2 class="font-bold text-slate-800 dark:text-white">Sales Role Guide</h2>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">Detailed guide for client-facing coordination, requirements validation, and handoff flow.</p>
            <span class="mt-3 inline-block text-xs font-semibold text-pink-500">Click to learn more →</span>
        </div>

        
        <div onclick="mvHelp('pre_sale_role')" style="order: 19;" class="help-card cursor-pointer rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
            <div class="mb-3 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-100 dark:bg-violet-900/40 text-violet-600 dark:text-violet-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4m4-10v10"/></svg>
                </div>
                <h2 class="font-bold text-slate-800 dark:text-white">Pre Sale Role Guide</h2>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">Detailed guide for discovery, scope definition, and handoff preparation before implementation.</p>
            <span class="mt-3 inline-block text-xs font-semibold text-violet-500">Click to learn more →</span>
        </div>

        
        <div onclick="mvHelp('it_role')" style="order: 20;" class="help-card cursor-pointer rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
            <div class="mb-3 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L8 21l-4-4 4-4m6.5 4L16 21l4-4-4-4M12 4v16"/></svg>
                </div>
                <h2 class="font-bold text-slate-800 dark:text-white">IT Role Guide</h2>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">Detailed guide for system support, user access, infrastructure checks, and internal troubleshooting.</p>
            <span class="mt-3 inline-block text-xs font-semibold text-indigo-500">Click to learn more →</span>
        </div>

        
        <div onclick="mvHelp('admin_role')" style="order: 21;" class="help-card cursor-pointer rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
            <div class="mb-3 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-100 dark:bg-orange-900/40 text-orange-600 dark:text-orange-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l7 4v6c0 5-3.5 9.5-7 11-3.5-1.5-7-6-7-11V7l7-4zm0 7a2 2 0 100 4 2 2 0 000-4zm0 4v4"/></svg>
                </div>
                <h2 class="font-bold text-slate-800 dark:text-white">Admin Role Guide</h2>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">Detailed guide for user management, system settings, permissions, and overall platform control.</p>
            <span class="mt-3 inline-block text-xs font-semibold text-orange-500">Click to learn more →</span>
        </div>

        
        <div onclick="mvHelp('email')" style="order: 14;" class="help-card cursor-pointer rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
            <div class="mb-3 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-100 dark:bg-sky-900/40 text-sky-600 dark:text-sky-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8m-18 8h18a2 2 0 002-2V8a2 2 0 00-2-2H3a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg>
                </div>
                <h2 class="font-bold text-slate-800 dark:text-white">Email Structure</h2>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">Use a clear email format for task updates, follow-ups, approvals, and escalation messages.</p>
            <span class="mt-3 inline-block text-xs font-semibold text-sky-500">Click to learn more →</span>
        </div>

        
        <div onclick="mvHelp('create_user')" style="order: 11;" class="help-card cursor-pointer rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
            <div class="mb-3 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-lime-100 dark:bg-lime-900/40 text-lime-600 dark:text-lime-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3M5 19a4 4 0 014-4h3a4 4 0 014 4M12 7a4 4 0 100-8 4 4 0 000 8z"/></svg>
                </div>
                <h2 class="font-bold text-slate-800 dark:text-white">Create User</h2>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">Step-by-step account provisioning with required fields, role assignment, and validation reminders.</p>
            <span class="mt-3 inline-block text-xs font-semibold text-lime-500">Click to learn more →</span>
        </div>

        
        <div onclick="mvHelp('audit_log')" style="order: 12;" class="help-card cursor-pointer rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
            <div class="mb-3 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-fuchsia-100 dark:bg-fuchsia-900/40 text-fuchsia-600 dark:text-fuchsia-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"/></svg>
                </div>
                <h2 class="font-bold text-slate-800 dark:text-white">Audit Log Guide</h2>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">Understand who changed what, when it happened, and how to filter entries for investigations.</p>
            <span class="mt-3 inline-block text-xs font-semibold text-fuchsia-500">Click to learn more →</span>
        </div>

        
        <div onclick="mvHelp('admin_config')" style="order: 13;" class="help-card cursor-pointer rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
            <div class="mb-3 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-100 dark:bg-orange-900/40 text-orange-600 dark:text-orange-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317a1 1 0 011.35-.936l.963.385a1 1 0 00.913-.045l.918-.53a1 1 0 011.397.366l.5.866a1 1 0 00.77.5l1.002.136a1 1 0 01.85 1.028l-.04 1a1 1 0 00.273.725l.692.724a1 1 0 010 1.382l-.692.724a1 1 0 00-.273.725l.04 1a1 1 0 01-.85 1.028l-1.002.136a1 1 0 00-.77.5l-.5.866a1 1 0 01-1.397.366l-.918-.53a1 1 0 00-.913-.045l-.963.385a1 1 0 01-1.35-.936V4.317z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9a3 3 0 100 6 3 3 0 000-6z"/></svg>
                </div>
                <h2 class="font-bold text-slate-800 dark:text-white">Admin Configuration</h2>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">Field-by-field guide for alert emails, broadcast settings, and safe configuration updates.</p>
            <span class="mt-3 inline-block text-xs font-semibold text-orange-500">Click to learn more →</span>
        </div>

        
        <div onclick="mvHelp('role_matrix')" style="order: 15;" class="help-card cursor-pointer rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
            <div class="mb-3 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h10a2 2 0 012 2v14a2 2 0 01-2 2z"/></svg>
                </div>
                <h2 class="font-bold text-slate-800 dark:text-white">Role-Permission Matrix</h2>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">Clear matrix of which role can view, create, edit, approve, and configure each module.</p>
            <span class="mt-3 inline-block text-xs font-semibold text-blue-500">Click to learn more →</span>
        </div>

        
        <div onclick="mvHelp('notif_email_matrix')" style="order: 16;" class="help-card cursor-pointer rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
            <div class="mb-3 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-100 dark:bg-purple-900/40 text-purple-600 dark:text-purple-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h6m-6 4h10M5 5h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"/></svg>
                </div>
                <h2 class="font-bold text-slate-800 dark:text-white">Notification & Email Matrix</h2>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">Event-by-event matrix showing who receives in-app alerts and who receives email notifications.</p>
            <span class="mt-3 inline-block text-xs font-semibold text-purple-500">Click to learn more →</span>
        </div>

    </div>
</div>


<div id="mvHelpModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-sm px-4">
    <div class="relative w-full max-w-lg rounded-3xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-2xl overflow-hidden">

        
        <button onclick="mvCloseHelp()" class="absolute top-4 right-4 flex h-8 w-8 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-700 text-slate-500 hover:bg-slate-200 dark:hover:bg-slate-600 transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>

        
        <div id="mvHelpHeader" class="flex items-center gap-4 px-6 pt-6 pb-4 border-b border-slate-100 dark:border-slate-700">
            <div id="mvHelpIcon" class="flex h-12 w-12 items-center justify-center rounded-2xl text-white text-xl shadow-lg"></div>
            <div>
                <h2 id="mvHelpTitle" class="text-xl font-black text-slate-800 dark:text-white"></h2>
                <p id="mvHelpSub" class="text-xs text-slate-400 dark:text-slate-500 mt-0.5"></p>
            </div>
        </div>

        
        <div id="mvHelpBody" class="px-6 py-5 space-y-3 max-h-[60vh] overflow-y-auto text-sm text-slate-600 dark:text-slate-300"></div>

        
        <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700 flex justify-end">
            <button onclick="mvCloseHelp()" class="rounded-xl bg-blue-600 px-5 py-2 text-sm font-bold text-white hover:bg-blue-700 transition">Got it</button>
        </div>
    </div>
</div>

<script>
const mvHelpData = {
    login: {
        title: 'Login Page',
        sub: 'Sign in to open the workspace',
        icon: '🔐',
        bg: 'bg-gradient-to-br from-slate-600 to-slate-800',
        items: [
            { label: 'Work Email', desc: 'Enter your official company email address so your assigned role and menu access can be loaded correctly.' },
            { label: 'Password', desc: 'Use the password provided by the Admin or the password you already updated after your first sign-in.' },
            { label: 'Sign In Button', desc: 'Click Sign In to open the dashboard and continue to the rest of the modules in this manual.' },
            { label: 'Invalid Login', desc: 'If the email or password is incorrect, recheck the input first before asking Admin for a reset.' },
            { label: 'Forgot Password or Access Issue', desc: 'If you cannot log in, contact Admin or IT so they can verify your account and reset access if needed.' },
            { label: 'Next Step', desc: 'After login, proceed to the Dashboard first, then Projects, then My Tasks for the normal user flow.' },
        ]
    },
    dashboard: {
        title: 'Dashboard',
        sub: 'Your main overview screen',
        icon: '🏠',
        bg: 'bg-gradient-to-br from-blue-500 to-cyan-500',
        items: [
            { label: 'Active Projects', desc: 'Shows the number of projects you are currently a member of.' },
            { label: 'My Tasks', desc: 'Count of all tasks assigned to you that are not yet marked as Done.' },
            { label: 'Pending Review', desc: 'Tasks that have been submitted for review and are waiting for approval.' },
            { label: 'Overdue', desc: 'Tasks whose due date has already passed but are still not completed.' },
            { label: 'Task Status Chart', desc: 'A visual breakdown (chart) showing how many tasks are in each status: Todo, In Progress, For Review, and Done.' },
            { label: 'Tasks Over Time', desc: 'A line chart showing how many tasks were created each day over the last 7 days.' },
            { label: 'Project Progress', desc: 'Per-project completion percentage, split by Sales and Technical team tabs.' },
            { label: 'Recent Activity', desc: 'The latest actions done on tasks (status changes, comments, assignments).' },
            { label: 'Upcoming Meetings', desc: 'Meetings scheduled from today onwards.' },
        ]
    },
    tasks: {
        title: 'My Tasks',
        sub: 'Manage your assigned tasks',
        icon: '✅',
        bg: 'bg-gradient-to-br from-purple-500 to-violet-500',
        items: [
            { label: 'Task List View', desc: 'Displays all tasks assigned to you in a table format with filters for status, priority, and project.' },
            { label: 'Create Task', desc: 'Only admins, managers, and project managers can create new tasks and assign them to team members.' },
            { label: 'Task Status', desc: 'Each task has a status: Todo → In Progress → For Review → Done.' },
            { label: 'Priority Levels', desc: 'Tasks can be tagged as Low, Medium, High, or Critical priority.' },
            { label: 'Due Date', desc: 'The deadline for a task. Tasks past their due date are marked as Overdue.' },
            { label: 'Assignees', desc: 'One or more users who are responsible for completing the task.' },
            { label: 'Task Detail Page', desc: 'Click a task to view full details, add comments, upload attachments, start a timer, and manage checklists.' },
        ]
    },
    kanban: {
        title: 'Kanban Board',
        sub: 'Visual task management by columns',
        icon: '📋',
        bg: 'bg-gradient-to-br from-teal-500 to-emerald-500',
        items: [
            { label: 'Columns', desc: 'Tasks are grouped into 4 columns: To Do, In Progress, For Review, and Done.' },
            { label: 'Drag & Drop', desc: 'Move a task card from one column to another to update its status instantly.' },
            { label: 'Task Cards', desc: 'Each card shows the task title, priority badge, assignee avatars, and due date.' },
            { label: 'Quick View', desc: 'Click a task card to open the full task details without leaving the Kanban page.' },
            { label: 'Filters', desc: 'Filter the board by project, assignee, or priority to focus on specific tasks.' },
        ]
    },
    calendar: {
        title: 'Calendar',
        sub: 'Monthly view of tasks and events',
        icon: '📅',
        bg: 'bg-gradient-to-br from-cyan-500 to-sky-500',
        items: [
            { label: 'Event Calendar', desc: 'Shows all scheduled Meetings and company Holidays for the month.' },
            { label: 'Tasks Calendar', desc: 'Shows active tasks placed on their due date on a monthly grid.' },
            { label: 'All Movaflex', desc: 'Shows tasks from all teams combined (Sales + Technical).' },
            { label: 'Sales filter', desc: 'Shows only tasks assigned to Sales team members.' },
            { label: 'Technical filter', desc: 'Shows only tasks assigned to Technical team members.' },
            { label: 'Highlighted dates', desc: 'Dates with tasks or events have a teal glow around the day number.' },
            { label: 'Today indicator', desc: 'Today\'s date is highlighted with a blue circle.' },
            { label: 'Previous / Next', desc: 'Navigate to previous or next months using the navigation buttons.' },
        ]
    },
    projects: {
        title: 'Projects',
        sub: 'Create and manage company projects',
        icon: '📁',
        bg: 'bg-gradient-to-br from-indigo-500 to-blue-600',
        items: [
            { label: 'Create Project', desc: 'Admins and Project Managers can create new projects with a name, description, and team members.' },
            { label: 'Project Members', desc: 'Users added as members of a project can see and be assigned tasks under that project.' },
            { label: 'Project Progress', desc: 'Shown as a percentage based on how many tasks in the project are marked Done.' },
            { label: 'Sales vs Technical', desc: 'Project progress is split into Sales team and Technical team tabs for easy tracking.' },
            { label: 'Edit Project', desc: 'Update the project name, description, or members at any time.' },
        ]
    },
    meetings: {
        title: 'Meetings',
        sub: 'Schedule and track team meetings',
        icon: '🎥',
        bg: 'bg-gradient-to-br from-violet-500 to-purple-600',
        items: [
            { label: 'Create Meeting', desc: 'Add a new meeting with a title, date, start time, and optional description.' },
            { label: 'Meeting List', desc: 'View all past and upcoming meetings in chronological order.' },
            { label: 'Calendar Integration', desc: 'All meetings automatically appear on the Company Calendar under the Event Calendar section.' },
            { label: 'Meeting Detail', desc: 'Click a meeting to see its full details including attendees and notes.' },
        ]
    },
    notifications: {
        title: 'Notifications',
        sub: 'Stay updated with real-time alerts',
        icon: '🔔',
        bg: 'bg-gradient-to-br from-rose-500 to-pink-500',
        items: [
            { label: 'Bell Icon', desc: 'The bell icon in the top navigation bar shows the number of unread notifications with a red badge.' },
            { label: 'Task Assigned', desc: 'You receive a notification whenever a task is assigned to you.' },
            { label: 'Task Updated', desc: 'Get notified when a task you are assigned to is updated or its status changes.' },
            { label: 'Overdue Alert', desc: 'Automatic notification when a task is past its due date.' },
            { label: 'Mark as Read', desc: 'Click a notification to mark it as read, or use "Mark All as Read" to clear all at once.' },
            { label: 'Notification History', desc: 'View all past notifications (read and unread) from the Notifications History page.' },
        ]
    },
    status: {
        title: 'Task Status Guide',
        sub: 'What each task status means',
        icon: '🏷️',
        bg: 'bg-gradient-to-br from-amber-500 to-orange-500',
        items: [
            { label: '⚪ Todo', desc: 'The task has been created but no one has started working on it yet.' },
            { label: '🔵 In Progress', desc: 'Someone is actively working on this task.' },
            { label: '🟠 For Review', desc: 'The task is completed and is waiting to be reviewed and approved by a manager or lead.' },
            { label: '🟢 Done', desc: 'The task has been reviewed and fully completed. No more action needed.' },
            { label: '🔴 Overdue', desc: 'The task\'s due date has passed and it is still not marked as Done. Requires immediate attention.' },
        ]
    },
    roles: {
        title: 'User Roles',
        sub: 'Access levels in the system',
        icon: '👥',
        bg: 'bg-gradient-to-br from-emerald-500 to-green-600',
        items: [
            { label: 'Executive', desc: 'Reviews overall progress, team performance, and high-level reports for decision-making.' },
            { label: 'Project Manager', desc: 'Manages specific projects, creates tasks, assigns members, and tracks project progress.' },
            { label: 'Admin', desc: 'Full access to everything: create users, manage all projects and tasks, view all reports, and configure system settings.' },
            { label: 'Sales', desc: 'Handles client-facing work, sales-related tasks, and pre-implementation coordination.' },
            { label: 'Technical', desc: 'Manages technical delivery, implementation tasks, and system-related work.' },
            { label: 'Pre Sale', desc: 'Supports early-stage client requirements, scoping, and proposal preparation.' },
        ]
    },
    technical_role: {
        title: 'Technical Role Guide',
        sub: 'Technical delivery and execution responsibilities',
        icon: '🛠️',
        bg: 'bg-gradient-to-br from-sky-500 to-cyan-600',
        items: [
            { label: 'Primary Purpose', desc: 'Handle implementation work, fixes, testing, and task execution on the technical side of projects.' },
            { label: 'Main Responsibilities', desc: 'Review technical requirements, build or adjust solutions, resolve issues, and update task progress.' },
            { label: 'Task Flow', desc: 'Usually receives work from Sales or Pre Sale, completes the implementation, then submits the task for review.' },
            { label: 'What Technical Can Do', desc: 'Work on assigned technical tasks, comment on blockers, update statuses, and participate in delivery coordination.' },
            { label: 'What Technical Should Escalate', desc: 'Escalate scope changes, access issues, unresolved blockers, and cases that need Admin or PM approval.' },
            { label: 'Daily Output Examples', desc: 'Bug fixes, setup adjustments, technical checks, implementation updates, and test verification.' },
        ]
    },
    sales_role: {
        title: 'Sales Role Guide',
        sub: 'Client-facing and commercial execution responsibilities',
        icon: '📈',
        bg: 'bg-gradient-to-br from-pink-500 to-rose-600',
        items: [
            { label: 'Primary Purpose', desc: 'Handle client-facing coordination, requirement intake, and commercial communication.' },
            { label: 'Main Responsibilities', desc: 'Capture client requests, clarify scope, create/update sales-related tasks, and monitor commitments.' },
            { label: 'Task Flow', desc: 'Collect requirements -> validate details -> create/update task -> coordinate with Pre Sale/Technical -> monitor completion.' },
            { label: 'What Sales Can Do', desc: 'Update task statuses, add progress notes, follow up with stakeholders, and coordinate deadlines.' },
            { label: 'What Sales Should Escalate', desc: 'Escalate requirement conflicts, timeline risks, and approvals needing Admin or Project Manager decisions.' },
            { label: 'Daily Output Examples', desc: 'Client follow-ups, requirement updates, handoff notes, and status reporting.' },
        ]
    },
    pre_sale_role: {
        title: 'Pre Sale Role Guide',
        sub: 'Discovery, scoping, and pre-implementation responsibilities',
        icon: '🧩',
        bg: 'bg-gradient-to-br from-violet-500 to-purple-600',
        items: [
            { label: 'Primary Purpose', desc: 'Bridge initial client needs to executable project scope before delivery starts.' },
            { label: 'Main Responsibilities', desc: 'Gather requirements, clarify assumptions, define scope boundaries, and prepare handoff context.' },
            { label: 'Task Flow', desc: 'Discover requirements -> validate business need -> document scope -> align with Sales -> handoff to Technical.' },
            { label: 'What Pre Sale Can Do', desc: 'Create scoping tasks, document requirements, tag dependencies, and coordinate pre-implementation readiness.' },
            { label: 'What Pre Sale Should Escalate', desc: 'Escalate unclear requirements, pricing or scope conflicts, and high-risk assumptions requiring PM/Admin decision.' },
            { label: 'Daily Output Examples', desc: 'Discovery notes, scope breakdown, requirement checklists, and handoff summaries.' },
        ]
    },
    it_role: {
        title: 'IT Role Guide',
        sub: 'System support and internal operations responsibilities',
        icon: '🖥️',
        bg: 'bg-gradient-to-br from-indigo-500 to-blue-600',
        items: [
            { label: 'Primary Purpose', desc: 'Maintain system health, support users, and manage internal technical operations that keep the platform running.' },
            { label: 'Main Responsibilities', desc: 'Handle access issues, verify system settings, monitor availability, and assist with troubleshooting.' },
            { label: 'Task Flow', desc: 'Receive issue -> diagnose problem -> apply fix or workaround -> verify resolution -> document outcome.' },
            { label: 'What IT Can Do', desc: 'Reset or verify access, assist with configuration, investigate technical incidents, and coordinate with Admin or Technical teams.' },
            { label: 'What IT Should Escalate', desc: 'Escalate code defects, environment failures, permission conflicts, and issues requiring higher-level technical intervention.' },
            { label: 'Daily Output Examples', desc: 'User support, access validation, system checks, incident review, and internal troubleshooting updates.' },
        ]
    },
    admin_role: {
        title: 'Admin Role Guide',
        sub: 'Platform governance and user management responsibilities',
        icon: '🛡️',
        bg: 'bg-gradient-to-br from-orange-500 to-amber-600',
        items: [
            { label: 'Primary Purpose', desc: 'Control platform access, manage users, configure system settings, and oversee overall governance.' },
            { label: 'Main Responsibilities', desc: 'Create users, assign roles, review configuration, manage permissions, and support operational controls.' },
            { label: 'Task Flow', desc: 'Receive admin request -> validate access need -> apply changes -> verify effect -> document action in audit log.' },
            { label: 'What Admin Can Do', desc: 'Manage users, settings, email configurations, and broad project/task access depending on policy.' },
            { label: 'What Admin Should Escalate', desc: 'Escalate application bugs, infrastructure issues, and requests that need development or vendor intervention.' },
            { label: 'Daily Output Examples', desc: 'User provisioning, role updates, configuration review, and system governance checks.' },
        ]
    },
    email: {
        title: 'Email Structure',
        sub: 'Recommended email format for work updates',
        icon: '✉️',
        bg: 'bg-gradient-to-br from-sky-500 to-blue-600',
        items: [
            { label: 'Subject Format', desc: 'Use this pattern: [Project/Team] Action - Task Name - Date. Example: [Website Revamp] Follow-up - Homepage QA - 2026-05-11.' },
            { label: 'Greeting', desc: 'Start with a short and respectful greeting, and mention the recipient/group clearly.' },
            { label: 'Purpose (First 1-2 lines)', desc: 'State the intent immediately: update, request for approval, follow-up, issue escalation, or meeting confirmation.' },
            { label: 'Task/Issue Details', desc: 'Include task title, owner, deadline, current status, blockers, and what has been completed so far.' },
            { label: 'Action Required', desc: 'Specify exactly what you need from the recipient, who should do it, and the expected completion time.' },
            { label: 'Attachment/Reference', desc: 'If you attached files or links, mention them explicitly so the recipient can review quickly.' },
            { label: 'Closing Line', desc: 'End with a brief thank you and your name/role for accountability.' },
            { label: 'Quick Template', desc: 'Hi [Name/Team],\\nPurpose: [Update/Request]\\nTask: [Task Name]\\nStatus: [Current Status]\\nDeadline: [Date/Time]\\nAction Needed: [Specific Action]\\nReference: [Link/Attachment]\\nThank you,\\n[Your Name]' },
            { label: 'Quality Checklist', desc: 'Before sending, ensure the message is clear, complete, and professional with no missing deadline or owner.' },
        ]
    },
    create_user: {
        title: 'Create User',
        sub: 'Account provisioning and role assignment',
        icon: '👤',
        bg: 'bg-gradient-to-br from-lime-500 to-emerald-500',
        items: [
            { label: 'Purpose', desc: 'Create a new account for executive, project manager, admin, sales, technical, or pre sale users with the right access level.' },
            { label: 'Access', desc: 'Only Admin users can create new user accounts.' },
            { label: 'Required Fields', desc: 'Complete full name, email address, role, and assigned team before saving.' },
            { label: 'Email Standard', desc: 'Use official work email format and double-check spelling to avoid login and notification issues.' },
            { label: 'Role Assignment', desc: 'Select the role carefully because it controls what menus, pages, and actions are available.' },
            { label: 'Verification Step', desc: 'After creating, confirm the user appears in the user list and can sign in successfully.' },
            { label: 'Common Errors', desc: 'Duplicate email, missing role, or invalid email format will prevent account creation.' },
        ]
    },
    audit_log: {
        title: 'Audit Log Guide',
        sub: 'Trace system activity and accountability',
        icon: '🧾',
        bg: 'bg-gradient-to-br from-fuchsia-500 to-pink-600',
        items: [
            { label: 'Purpose', desc: 'Audit logs record who did what action, in which module, and at what time.' },
            { label: 'Access', desc: 'Users with proper permission can review logs for compliance and investigation.' },
            { label: 'Core Fields', desc: 'Read actor, action type, target record, timestamp, and related module details.' },
            { label: 'Filters', desc: 'Narrow down results by date, user, or action to find exact events quickly.' },
            { label: 'How to Investigate', desc: 'Start from the reported issue time, then trace nearby actions to identify the root cause.' },
            { label: 'Best Practice', desc: 'Capture task ID or project ID first before searching so findings are more accurate.' },
        ]
    },
    admin_config: {
        title: 'Admin Configuration',
        sub: 'System settings and email behavior',
        icon: '⚙️',
        bg: 'bg-gradient-to-br from-orange-500 to-amber-600',
        items: [
            { label: 'Purpose', desc: 'Manage global settings such as alert recipients, broadcast email options, and operational defaults.' },
            { label: 'Field-by-Field Review', desc: 'Read each label and helper text before editing to avoid unintended system-wide changes.' },
            { label: 'Alert Emails', desc: 'Use valid comma-separated email addresses for daily summaries and monitoring notifications.' },
            { label: 'Personal Alert Email', desc: 'Set a valid inbox for urgent deadline alerts and verify it can receive external messages.' },
            { label: 'BCC Audit Email', desc: 'Optional archive inbox for compliance tracking of outgoing deadline alert emails.' },
            { label: 'Save and Confirm', desc: 'After saving, send a test email and verify recipients receive the message correctly.' },
            { label: 'Common Mistakes', desc: 'Invalid email format, empty required fields, or wrong recipient list causes delivery failure.' },
        ]
    },
    role_matrix: {
        title: 'Role-Permission Matrix',
        sub: 'Who can do what in each module',
        icon: '📊',
        bg: 'bg-gradient-to-br from-blue-500 to-indigo-600',
        items: [
            { label: 'Executive', desc: 'Can view global reports and high-level project progress; usually approval and oversight focused.' },
            { label: 'Project Manager', desc: 'Can create projects/tasks, assign members, and approve task completion in project workflows.' },
            { label: 'Admin', desc: 'Full system access including user management, settings, and all project/task operations.' },
            { label: 'Sales', desc: 'Can view and update tasks scoped to sales responsibilities and assigned projects.' },
            { label: 'Technical', desc: 'Can work on technical tasks, update status, and contribute to project delivery milestones.' },
            { label: 'Pre Sale', desc: 'Can manage early-stage requirements, scope preparation tasks, and pre-implementation activities.' },
            { label: 'How to Use Matrix', desc: 'If access is denied, check both role assignment and project membership before escalating.' },
        ]
    },
    notif_email_matrix: {
        title: 'Notification & Email Matrix',
        sub: 'Event-to-recipient mapping',
        icon: '📬',
        bg: 'bg-gradient-to-br from-purple-500 to-violet-600',
        items: [
            { label: 'Task Assigned', desc: 'In-app: Assignee. Email: Assignee (if enabled).' },
            { label: 'Status Changed', desc: 'In-app: Task creator and related team members. Email: Optional depending on alert configuration.' },
            { label: 'Task Overdue', desc: 'In-app: Assignee and managers/PM. Email: Alert recipients and optional audit BCC.' },
            { label: 'For Review Submitted', desc: 'In-app: PM/Admin reviewers. Email: Reviewer group when configured.' },
            { label: 'Meeting Scheduled', desc: 'In-app: Invited users. Email: Optional meeting notice based on settings.' },
            { label: 'Daily Summary', desc: 'In-app: Not applicable. Email: Configured broadcast recipients at scheduled time.' },
            { label: 'Verification Step', desc: 'Test using a sample task event after configuration changes to confirm delivery path.' },
        ]
    },
};

function mvHelp(key) {
    const d = mvHelpData[key];
    if (!d) return;
    document.getElementById('mvHelpIcon').innerHTML = d.icon;
    document.getElementById('mvHelpIcon').className = 'flex h-12 w-12 items-center justify-center rounded-2xl text-2xl shadow-lg ' + d.bg;
    document.getElementById('mvHelpTitle').textContent = d.title;
    document.getElementById('mvHelpSub').textContent = d.sub;

    const body = document.getElementById('mvHelpBody');
    body.innerHTML = d.items.map(item => `
        <div class="flex gap-3 rounded-xl border border-slate-100 dark:border-slate-700 bg-slate-50 dark:bg-slate-700/50 p-3">
            <div class="mt-0.5 h-2 w-2 shrink-0 rounded-full bg-blue-500 mt-2"></div>
            <div>
                <p class="font-bold text-slate-800 dark:text-white text-sm">${item.label}</p>
                <p class="text-slate-500 dark:text-slate-400 text-xs mt-0.5">${item.desc}</p>
            </div>
        </div>
    `).join('');

    const modal = document.getElementById('mvHelpModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function mvCloseHelp() {
    const modal = document.getElementById('mvHelpModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

document.getElementById('mvHelpModal').addEventListener('click', function(e) {
    if (e.target === this) mvCloseHelp();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views\help.blade.php ENDPATH**/ ?>