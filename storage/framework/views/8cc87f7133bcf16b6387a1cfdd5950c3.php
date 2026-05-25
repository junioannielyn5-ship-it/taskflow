<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Movaflex Task Manager</title>
    <script>
        // Dark mode: apply before render to prevent flash
        (function() {
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/chart-global.ts']); ?>
    
    <script src="/js/lucide.min.js"></script>
    <script defer src="/js/alpine.min.js"></script>
    <script src="/js/darkmode.js"></script>

    
    <style>
        /* ===== GLASSMORPHISM TOAST SYSTEM ===== */
        #mv-toast-container {
            position: fixed;
            top: 5rem;
            right: 1.25rem;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            pointer-events: none;
            max-width: 420px;
            width: calc(100% - 2.5rem);
        }
        .mv-toast {
            pointer-events: auto;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 0.875rem 1rem;
            border-radius: 1rem;
            border: 1px solid rgba(255,255,255,0.18);
            backdrop-filter: blur(18px) saturate(1.6);
            -webkit-backdrop-filter: blur(18px) saturate(1.6);
            box-shadow: 0 8px 32px rgba(0,0,0,0.12), inset 0 1px 0 rgba(255,255,255,0.15);
            animation: mv-toast-in 0.4s cubic-bezier(0.22, 1, 0.36, 1) forwards;
            transform: translateX(120%);
            opacity: 0;
        }
        .mv-toast.mv-toast-exit {
            animation: mv-toast-out 0.35s cubic-bezier(0.55, 0, 1, 0.45) forwards;
        }
        @keyframes mv-toast-in {
            0% { transform: translateX(120%); opacity: 0; }
            100% { transform: translateX(0); opacity: 1; }
        }
        @keyframes mv-toast-out {
            0% { transform: translateX(0); opacity: 1; }
            100% { transform: translateX(120%); opacity: 0; }
        }
        /* Progress bar */
        .mv-toast-progress {
            position: absolute;
            bottom: 0; left: 0;
            height: 3px;
            border-radius: 0 0 1rem 1rem;
            animation: mv-toast-progress linear forwards;
        }
        @keyframes mv-toast-progress {
            0% { width: 100%; }
            100% { width: 0%; }
        }
        /* Types */
        .mv-toast--success {
            background: rgba(16, 185, 129, 0.12);
            border-color: rgba(16, 185, 129, 0.25);
        }
        .mv-toast--success .mv-toast-icon { color: #10b981; }
        .mv-toast--success .mv-toast-progress { background: linear-gradient(90deg, #10b981, #34d399); }

        .mv-toast--error {
            background: rgba(239, 68, 68, 0.12);
            border-color: rgba(239, 68, 68, 0.25);
        }
        .mv-toast--error .mv-toast-icon { color: #ef4444; }
        .mv-toast--error .mv-toast-progress { background: linear-gradient(90deg, #ef4444, #f87171); }

        .mv-toast--info {
            background: rgba(59, 130, 246, 0.12);
            border-color: rgba(59, 130, 246, 0.25);
        }
        .mv-toast--info .mv-toast-icon { color: #3b82f6; }
        .mv-toast--info .mv-toast-progress { background: linear-gradient(90deg, #3b82f6, #60a5fa); }

        .mv-toast--warning {
            background: rgba(245, 158, 11, 0.12);
            border-color: rgba(245, 158, 11, 0.25);
        }
        .mv-toast--warning .mv-toast-icon { color: #f59e0b; }
        .mv-toast--warning .mv-toast-progress { background: linear-gradient(90deg, #f59e0b, #fbbf24); }

        /* Dark mode refinements */
        .dark .mv-toast--success { background: rgba(16, 185, 129, 0.15); border-color: rgba(16, 185, 129, 0.3); }
        .dark .mv-toast--error   { background: rgba(239, 68, 68, 0.15); border-color: rgba(239, 68, 68, 0.3); }
        .dark .mv-toast--info    { background: rgba(59, 130, 246, 0.15); border-color: rgba(59, 130, 246, 0.3); }
        .dark .mv-toast--warning { background: rgba(245, 158, 11, 0.15); border-color: rgba(245, 158, 11, 0.3); }
    </style>
    
</head>
<body class="mv-body m-0 p-0 min-h-screen bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 antialiased">


<div id="mv-toast-container"></div>

<div x-data="{ chatOpen: false, mobileMenuOpen: false }">
<?php
    $topNavItems = [
        [
            'label' => 'Dashboard',
            'href' => route('dashboard'),
            'active' => request()->routeIs('dashboard*'),
            'icon' => 'layout-dashboard',
        ],
        [
            'label' => 'Projects',
            'href' => url('/projects'),
            'active' => request()->routeIs('projects.*'),
            'icon' => 'folder-kanban',
        ],
        [
            'label' => 'Task Manager',
            'href' => route('tasks.list'),
            'active' => request()->routeIs('tasks.*') && !request()->routeIs('tasks.kanban') && !request()->routeIs('tasks.calendar'),
            'icon' => 'clipboard-list',
        ],
        [
            'label' => 'Kanban',
            'href' => route('tasks.kanban'),
            'active' => request()->routeIs('tasks.kanban'),
            'icon' => 'columns-3',
        ],
        [
            'label' => 'Audit Log',
            'href' => route('audit-logs.index'),
            'active' => request()->routeIs('audit-logs.*'),
            'icon' => 'scroll-text',
        ],
    ];
?>


<nav class="sticky top-0 z-50 w-full border-b border-slate-200/80 dark:border-slate-800/80 bg-white/70 dark:bg-slate-900/70 backdrop-blur-md transition-all duration-300">
    
    <div class="pointer-events-none absolute left-1/4 top-0 h-12 w-96 -translate-x-1/2 rounded-full bg-gradient-to-r from-blue-500/10 to-indigo-500/10 dark:from-blue-500/20 dark:to-indigo-500/20 blur-2xl"></div>
    
    <div class="relative z-10 mx-auto flex h-16 w-full max-w-full items-center justify-between px-4 sm:px-6 lg:px-8 xl:px-10">

        
        <div class="flex shrink-0 items-center">
            <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center gap-2 group">
                 <img src="<?php echo e(asset('images/movaflex-logo-official.png')); ?>"
                    class="h-12 w-auto object-contain transform group-hover:scale-105 transition-transform duration-300 saturate-125 contrast-110 brightness-105 dark:saturate-100 dark:contrast-150 dark:brightness-150 dark:drop-shadow-[0_0_12px_rgba(59,130,246,0.8)]"
                    alt="Movaflex">
                 <div class="w-px h-6 bg-slate-300 dark:bg-slate-700 mx-1"></div>
                 <span class="text-xs font-bold tracking-[0.2em] uppercase text-slate-400 group-hover:text-blue-500 transition-colors">Workspace</span>
            </a>
        </div>

        <?php if(auth()->guard()->check()): ?>
        
        <div class="hidden lg:flex items-center gap-1 bg-slate-100/80 dark:bg-slate-800/60 p-1 rounded-xl border border-slate-200/50 dark:border-slate-700/50">
            <?php
                $navBase   = "inline-flex items-center gap-1.5 rounded-lg px-3.5 py-1.5 text-xs font-semibold transition-all duration-200";
                $navActive = "bg-white dark:bg-slate-700 text-blue-600 dark:text-blue-300 shadow-sm border border-slate-200/60 dark:border-slate-600/50";
                $navIdle   = "text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-white/50 dark:hover:bg-slate-800/50 border border-transparent";
            ?>

            <?php $__currentLoopData = $topNavItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e($item['href']); ?>" class="<?php echo e($navBase); ?> <?php echo e($item['active'] ? $navActive : $navIdle); ?>">
                    <i data-lucide="<?php echo e($item['icon']); ?>" class="h-3.5 w-3.5"></i>
                    <?php echo e($item['label']); ?>

                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php if(auth()->user()->isAdmin()): ?>
            <a href="<?php echo e(route('users.index')); ?>" class="<?php echo e($navBase); ?> <?php echo e(request()->routeIs('users.*') ? $navActive : $navIdle); ?>">
                    <i data-lucide="user-plus" class="h-3.5 w-3.5"></i>
                    Create User
                </a>
            <?php endif; ?>
        </div>

        
        <div class="relative z-20 hidden lg:flex items-center gap-1" x-data="{ userMenu: false }">
            
            <?php
                $unreadNotifCount = \App\Modules\Notifications\Models\Notification::where('user_id', auth()->id())->unread()->count();
            ?>
            <a href="<?php echo e(route('notifications.history')); ?>" class="relative rounded-xl p-2 text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-100 transition-all">
                <i data-lucide="bell" class="h-4 w-4"></i>
                <?php if($unreadNotifCount > 0): ?>
                    <span class="absolute -right-1 -top-1 flex h-4 w-4 items-center justify-center rounded-full bg-rose-500 text-[10px] font-bold text-white ring-2 ring-white dark:ring-slate-900 shadow-sm"><?php echo e($unreadNotifCount > 99 ? '99+' : $unreadNotifCount); ?></span>
                <?php endif; ?>
            </a>

            
            <a href="<?php echo e(route('email.shortcut')); ?>" class="rounded-xl p-2 text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-100 transition-all">
                <i data-lucide="mail" class="h-4 w-4"></i>
            </a>

            
            <button @click="chatOpen = true" class="relative rounded-xl p-2 text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-100 transition-all" title="Group Chat">
                <i data-lucide="message-circle" class="h-4 w-4"></i>
                <span id="chat-unread-dot" class="hidden absolute top-2 right-2 flex h-1.5 w-1.5 rounded-full bg-rose-500 ring-2 ring-white dark:ring-slate-900"></span>
            </button>

            
            <button onclick="toggleDarkMode()" class="rounded-xl p-2 text-slate-500 dark:text-amber-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 transition-all" title="Toggle Dark Mode">
                <i data-lucide="sun" class="h-4 w-4 hidden dark:block"></i>
                <i data-lucide="moon" class="h-4 w-4 block dark:hidden"></i>
            </button>

            <div class="mx-2 h-4 w-px bg-slate-200 dark:bg-slate-800"></div>

            
            <div class="relative">
                <button id="desktop-user-menu-trigger" type="button" @click="userMenu = !userMenu" class="flex items-center gap-2 rounded-xl p-1 pr-2 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all focus:outline-none border border-transparent hover:border-slate-200/60 dark:hover:border-slate-700/60">
                    <?php if(auth()->user()->profile_photo_path): ?>
                        <img src="<?php echo e(asset('storage/' . auth()->user()->profile_photo_path)); ?>" class="h-6 w-6 rounded-lg object-cover" alt="Profile">
                    <?php else: ?>
                        <div class="flex h-6 w-6 items-center justify-center rounded-lg bg-gradient-to-br from-blue-600 to-indigo-600 text-[10px] font-bold text-white shadow-sm">
                            <?php echo e(strtoupper(substr(auth()->user()->name ?? 'U', 0, 1))); ?>

                        </div>
                    <?php endif; ?>
                    <span class="text-xs font-semibold text-slate-700 dark:text-slate-300 xl:inline"><?php echo e(Str::limit(auth()->user()->name, 12)); ?></span>
                    <i data-lucide="chevron-down" class="h-3 w-3 text-slate-400 transform transition-transform duration-200" :class="userMenu && 'rotate-180'"></i>
                </button>

                 <div id="desktop-user-menu-panel" x-show="userMenu" x-cloak @click.outside="userMenu = false"
                      x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                      x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                      class="absolute right-0 mt-2 w-48 origin-top-right rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-1 shadow-lg z-50">
                    <a href="<?php echo e(route('profile.edit')); ?>" class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                        <i data-lucide="settings" class="h-3.5 w-3.5 text-slate-400"></i> Settings
                    </a>
                    <hr class="my-1 border-slate-100 dark:border-slate-800">
                    <a href="<?php echo e(route('logout.get')); ?>" class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors">
                        <i data-lucide="log-out" class="h-3.5 w-3.5"></i> Logout
                        <span class="ml-auto rounded-md bg-rose-100 dark:bg-rose-500/10 px-1.5 py-0.5 text-[9px] font-bold uppercase tracking-wide text-rose-600 dark:text-rose-400">Exit</span>
                    </a>
                </div>
            </div>
        </div>

        
        <div class="flex lg:hidden items-center gap-1">
            <button onclick="toggleDarkMode()" class="rounded-xl p-2 text-slate-500 dark:text-amber-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
                <i data-lucide="sun" class="h-4 w-4 hidden dark:block"></i>
                <i data-lucide="moon" class="h-4 w-4 block dark:hidden"></i>
            </button>
            <a href="<?php echo e(route('notifications.history')); ?>" class="relative rounded-xl p-2 text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800">
                <i data-lucide="bell" class="h-4 w-4"></i>
                <?php if($unreadNotifCount > 0): ?>
                    <span class="absolute -right-1 -top-1 flex h-4 w-4 items-center justify-center rounded-full bg-rose-500 text-[10px] font-bold text-white ring-2 ring-white dark:ring-slate-900 shadow-sm"><?php echo e($unreadNotifCount > 99 ? '99+' : $unreadNotifCount); ?></span>
                <?php endif; ?>
            </a>
            <button @click="chatOpen = true" class="relative rounded-xl p-2 text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800" title="Group Chat">
                <i data-lucide="message-circle" class="h-4 w-4"></i>
            </button>
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="rounded-xl p-2 text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors ml-1" aria-label="Toggle menu">
                <i data-lucide="menu" class="h-5 w-5" x-show="!mobileMenuOpen"></i>
                <i data-lucide="x" class="h-5 w-5" x-show="mobileMenuOpen" x-cloak></i>
            </button>
        </div>
        <?php endif; ?>
    </div>

    
    <?php if(auth()->guard()->check()): ?>
    <div x-show="mobileMenuOpen" x-cloak
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
         class="lg:hidden border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-xl"
         @click.away="mobileMenuOpen = false">
        <div class="px-4 py-3 space-y-1">
            <?php
                $mobileBase = "flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition-all";
                $mobileActive = "bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-200 dark:border-blue-800/40";
                $mobileInactive = "text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800";
            ?>

            <?php $__currentLoopData = $topNavItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e($item['href']); ?>" class="<?php echo e($mobileBase); ?> <?php echo e($item['active'] ? $mobileActive : $mobileInactive); ?>">
                <i data-lucide="<?php echo e($item['icon']); ?>" class="h-5 w-5"></i> <?php echo e($item['label']); ?>

            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php if(auth()->user()->isAdmin()): ?>
            <a href="<?php echo e(route('users.index')); ?>" class="<?php echo e($mobileBase); ?> <?php echo e(request()->routeIs('users.*') ? $mobileActive : $mobileInactive); ?>">
                <i data-lucide="user-plus" class="h-5 w-5"></i> Create User
            </a>
            <?php endif; ?>

            <hr class="border-slate-200 dark:border-slate-800 my-2">

            <a href="<?php echo e(route('email.shortcut')); ?>" class="<?php echo e($mobileBase); ?> <?php echo e($mobileInactive); ?>">
                <i data-lucide="mail" class="h-5 w-5"></i> Email
            </a>

            <a href="<?php echo e(route('profile.edit')); ?>" class="<?php echo e($mobileBase); ?> <?php echo e($mobileInactive); ?>">
                <i data-lucide="settings" class="h-5 w-5"></i> Account Settings
            </a>

            <a href="<?php echo e(route('logout.get')); ?>" class="<?php echo e($mobileBase); ?> bg-rose-50 dark:bg-rose-950/20 text-rose-600 dark:text-rose-400 border border-rose-100 dark:border-rose-900/40">
                <i data-lucide="log-out" class="h-5 w-5"></i> Logout
            </a>
        </div>
    </div>
    <?php endif; ?>
</nav>


<?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php $isDashboard = request()->routeIs('dashboard'); ?>
    <main class="<?php if($isDashboard): ?> w-full max-w-none p-0 m-0 <?php else: ?> w-full max-w-full px-4 sm:px-6 lg:px-8 xl:px-10 py-6 sm:py-8 <?php endif; ?>" style="min-height:0;">
        <div class="mv-page-enter <?php if($isDashboard): ?> w-full max-w-none p-0 m-0 <?php else: ?> mv-shell rounded-2xl sm:rounded-[2rem] glass-card p-4 sm:p-6 lg:p-8 shadow-2xl <?php endif; ?>">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </main>

    <?php if(!$isDashboard): ?>
    <footer class="mv-footer mt-12 border-t border-slate-200 dark:border-slate-800 bg-white/40 dark:bg-slate-900/40 py-8 text-center backdrop-blur-sm">
        <div class="flex flex-col items-center gap-2">
            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">
                &copy; 2026 <span class="text-blue-600 dark:text-blue-400">Movaflex</span> Designs Unlimited Inc.
            </p>
        </div>
    </footer>
    <?php endif; ?>


<?php if(auth()->guard()->check()): ?>
<div x-show="chatOpen"
     x-cloak
     style="display: none;"
     class="fixed inset-y-0 right-0 z-[60] w-80 lg:w-96 bg-white dark:bg-slate-900 shadow-2xl border-l border-slate-200 dark:border-slate-800 flex flex-col"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="translate-x-full"
     x-transition:enter-end="translate-x-0"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="translate-x-0"
     x-transition:leave-end="translate-x-full">

    <div class="px-5 py-4 flex flex-col gap-2 border-b border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800 shrink-0">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 bg-blue-100 dark:bg-blue-900/50 rounded-full flex items-center justify-center text-blue-600 dark:text-blue-400">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 dark:text-white leading-tight">Movaflex Team</h3>
                    <span class="text-xs text-emerald-500 font-medium">● All Staff Online</span>
                </div>
            </div>
            <button @click="chatOpen = false" class="p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-slate-700 rounded-full transition-colors focus:outline-none">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
        <div class="flex justify-between gap-2 mt-2">
            <button type="button" class="chat-group-btn flex-1 rounded-lg py-2 font-semibold text-sm transition bg-blue-600 text-white hover:bg-blue-700 focus:bg-blue-800" data-group="all">All Movaflex</button>
            <button type="button" class="chat-group-btn flex-1 rounded-lg py-2 font-semibold text-sm transition bg-violet-600 text-white hover:bg-violet-700 focus:bg-violet-800" data-group="sales">Sales</button>
            <button type="button" class="chat-group-btn flex-1 rounded-lg py-2 font-semibold text-sm transition bg-emerald-600 text-white hover:bg-emerald-700 focus:bg-emerald-800" data-group="technical">Technical</button>
        </div>
    </div>

    <div id="chat-panel-messages" class="flex-1 overflow-y-auto p-5 space-y-5 bg-white dark:bg-slate-900">
        <div id="chat-panel-loading" class="flex items-center justify-center h-full">
            <div class="text-center text-slate-400 dark:text-slate-500">
                <i data-lucide="loader-2" class="inline-block w-5 h-5 animate-spin mb-2"></i>
                <p class="text-sm">Loading messages...</p>
            </div>
        </div>
        <div id="chat-panel-empty" class="hidden items-center justify-center h-full">
            <div class="text-center text-slate-400 dark:text-slate-500">
                <i data-lucide="message-square-dashed" class="inline-block w-8 h-8 mb-2 opacity-50"></i>
                <p class="text-sm font-medium">Walang messages pa</p>
                <p class="text-xs">Maging una kang mag-send!</p>
            </div>
        </div>
    </div>

    <div class="p-4 border-t border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800 shrink-0">
        <form id="chat-panel-form" class="flex gap-2 relative">
            <label for="chat-panel-input" class="sr-only">Message</label>
            <input type="text" id="chat-panel-input" placeholder="Message the team..." maxlength="5000"
                   autocomplete="off"
                   class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl pl-4 pr-12 py-3 text-sm focus:ring-2 focus:ring-blue-600 outline-none text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 transition-colors">
            <button type="submit" id="chat-panel-send-btn" class="absolute right-1.5 top-1.5 bottom-1.5 px-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors flex items-center justify-center shadow-md disabled:opacity-50 disabled:cursor-not-allowed">
                <i data-lucide="send-horizontal" class="w-4 h-4"></i>
            </button>
        </form>
    </div>
</div>

<div x-show="chatOpen" x-cloak @click="chatOpen = false" class="fixed inset-0 z-[55] bg-black/20 backdrop-blur-sm lg:hidden"
     x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
     style="display: none;"></div>
<?php endif; ?>

</div>

    <script>
      lucide.createIcons();
    </script>

    <script>
    function toggleDarkMode() {
        var html = document.documentElement;
        html.classList.toggle('dark');
        var theme = html.classList.contains('dark') ? 'dark' : 'light';
        localStorage.setItem('theme', theme);
        window.dispatchEvent(new CustomEvent('theme-changed', { detail: { theme: theme } }));
    }
    </script>

    <?php if(auth()->guard()->check()): ?>
    <script>
        window.currentUserId = Number('<?php echo e(auth()->id()); ?>');
    </script>
    <?php endif; ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>

    
    <?php if(auth()->guard()->check()): ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var messagesBox = document.getElementById('chat-panel-messages');
        var loadingEl = document.getElementById('chat-panel-loading');
        var emptyEl = document.getElementById('chat-panel-empty');
        var form = document.getElementById('chat-panel-form');
        var input = document.getElementById('chat-panel-input');
        var sendBtn = document.getElementById('chat-panel-send-btn');
        var unreadDots = [
            document.getElementById('chat-unread-dot'),
            document.getElementById('chat-unread-dot-mobile')
        ].filter(Boolean);
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var currentUserId = window.currentUserId || null;
        var lastMessageId = 0;

        function isChatOpen() {
            var panel = document.querySelector('[x-show="chatOpen"]');
            return panel && panel.style.display !== 'none';
        }

        function escapeHtml(text) {
            var div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function getInitials(name) {
            return name.split(' ').map(function(w) { return w[0]; }).join('').toUpperCase().slice(0, 2);
        }

        function getAvatarColor(userId) {
            var colors = ['bg-blue-500','bg-emerald-500','bg-violet-500','bg-amber-500','bg-rose-500','bg-cyan-500','bg-indigo-500','bg-pink-500','bg-teal-500','bg-orange-500'];
            return colors[userId % colors.length];
        }

        function formatTime(dateString) {
            var date = new Date(dateString);
            var now = new Date();
            var isToday = date.toDateString() === now.toDateString();
            var time = date.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });
            if (isToday) return time;
            return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) + ' ' + time;
        }

        function createMessageEl(msg) {
            var isOwn = msg.user_id === currentUserId;
            var userName = msg.user ? msg.user.name : 'Unknown';
            var profilePhoto = msg.user && msg.user.profile_photo_path ? '/storage/' + msg.user.profile_photo_path : null;

            var wrapper = document.createElement('div');
            wrapper.className = 'flex flex-col ' + (isOwn ? 'items-end' : 'items-start');
            wrapper.dataset.messageId = msg.id;

            var avatarHtml = profilePhoto
                ? '<img src="' + escapeHtml(profilePhoto) + '" class="h-5 w-5 rounded-full object-cover">'
                : '<div class="h-5 w-5 rounded-full flex items-center justify-center text-[9px] font-bold text-white ' + getAvatarColor(msg.user_id) + '">' + escapeHtml(getInitials(userName)) + '</div>';

            var nameRow = isOwn ? '' : '<div class="flex items-center gap-2 mb-1">' + avatarHtml + '<span class="text-[11px] text-slate-500 dark:text-slate-400 font-bold">' + escapeHtml(userName) + '</span></div>';

            var bubbleClass = isOwn
                ? 'bg-blue-600 text-white px-4 py-2.5 rounded-2xl rounded-tr-none text-sm shadow-sm max-w-[85%]'
                : 'bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 rounded-2xl rounded-tl-none text-sm shadow-sm max-w-[85%]';

            var messageText = escapeHtml(msg.message).replace(/\n/g, '<br>');

            if (isOwn) {
                wrapper.innerHTML =
                    '<div class="flex items-center gap-1 flex-row-reverse">' +
                        '<div class="' + bubbleClass + '">' + messageText + '</div>' +
                        '<button type="button" onclick="window.deletePanelMessage(' + msg.id + ')" title="Delete" class="ml-1 p-1 bg-red-500 hover:bg-red-600 rounded-full flex items-center justify-center focus:outline-none" style="height:24px;width:24px;">' +
                            '<svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 20 20" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 8v6m4-6v6m5-10v2M4 6V4a2 2 0 012-2h4a2 2 0 012 2v2m2 0H4m2 0h8" /></svg>' +
                        '</button>' +
                    '</div>' +
                    '<span class="text-[10px] text-slate-400 mt-1 mr-1">' + formatTime(msg.created_at) + '</span>';
            } else {
                wrapper.innerHTML =
                    nameRow +
                    '<div class="group flex items-center gap-1">' +
                        '<div class="' + bubbleClass + '">' + messageText + '</div>' +
                    '</div>' +
                    '<span class="text-[10px] text-slate-400 mt-1 ml-1">' + formatTime(msg.created_at) + '</span>';
            }

            return wrapper;
        }

        function scrollToBottom() {
            messagesBox.scrollTop = messagesBox.scrollHeight;
        }

        function renderMessages(messages) {
            loadingEl.classList.add('hidden');
            emptyEl.classList.add('hidden');
            emptyEl.classList.remove('flex');

            if (messages.length === 0) {
                emptyEl.classList.remove('hidden');
                emptyEl.classList.add('flex');
                return;
            }

            messagesBox.querySelectorAll('[data-message-id]').forEach(function(el) { el.remove(); });

            messages.forEach(function(msg) {
                messagesBox.appendChild(createMessageEl(msg));
                if (msg.id > lastMessageId) lastMessageId = msg.id;
            });

            scrollToBottom();
        }

        function appendMessage(msg) {
            emptyEl.classList.add('hidden');
            emptyEl.classList.remove('flex');
            messagesBox.appendChild(createMessageEl(msg));
            if (msg.id > lastMessageId) lastMessageId = msg.id;
            scrollToBottom();
        }

        var currentGroup = 'all';
        function fetchMessages() {
            fetch('/messages?group=' + encodeURIComponent(currentGroup), {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(function(r) {
                if (r.status === 401) { clearInterval(chatPollInterval); window.location.href = '/login'; return; }
                if (!r.ok) throw new Error('fetch failed');
                return r.json();
            })
            .then(function(messages) {
                if (!messages) return;
                var hadMessages = lastMessageId;
                renderMessages(messages);
                if (messages.length > 0 && messages[messages.length - 1].id > hadMessages && hadMessages > 0 && !isChatOpen()) {
                    unreadDots.forEach(function(dot) {
                        dot.classList.remove('hidden');
                        dot.classList.add('flex');
                    });
                }
            })
            .catch(function(err) {
                console.error('Chat fetch error:', err);
            });
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            var message = input.value.trim();
            if (!message) return;

            sendBtn.disabled = true;
            input.disabled = true;

            fetch('/messages', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ message: message, group: currentGroup })
            })
            .then(function(r) { if (!r.ok) throw new Error('send failed'); return r.json(); })
            .then(function(msg) {
                appendMessage(msg);
                input.value = '';
            })
            .catch(function(err) {
                console.error('Chat send error:', err);
                alert('Hindi na-send ang message. Subukan ulit.');
            })
            .finally(function() {
                sendBtn.disabled = false;
                input.disabled = false;
                input.focus();
            });
        });

        document.querySelectorAll('.chat-group-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.chat-group-btn').forEach(function(b) {
                    b.classList.remove('ring', 'ring-2', 'ring-blue-400', 'ring-violet-400', 'ring-emerald-400');
                });
                currentGroup = btn.getAttribute('data-group');
                if(currentGroup === 'all') btn.classList.add('ring', 'ring-2', 'ring-blue-400');
                if(currentGroup === 'sales') btn.classList.add('ring', 'ring-2', 'ring-violet-400');
                if(currentGroup === 'technical') btn.classList.add('ring', 'ring-2', 'ring-emerald-400');
                fetchMessages();
            });
        });
        document.querySelector('.chat-group-btn[data-group="all"]').classList.add('ring', 'ring-2', 'ring-blue-400');

        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                form.dispatchEvent(new Event('submit'));
            }
        });

        document.addEventListener('click', function(e) {
            var btn = e.target.closest('[title="Group Chat"]');
            if (btn) {
                unreadDots.forEach(function(dot) {
                    dot.classList.add('hidden');
                    dot.classList.remove('flex');
                });
            }
        });

        window.deletePanelMessage = function(messageId) {
            if (!confirm('Delete this message?')) return;

            fetch('/messages/' + messageId, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(function(r) {
                if (!r.ok) throw new Error('delete failed');
                return r.json();
            })
            .then(function() {
                var el = messagesBox.querySelector('[data-message-id="' + messageId + '"]');
                if (el) el.remove();
                if (messagesBox.querySelectorAll('[data-message-id]').length === 0) {
                    emptyEl.classList.remove('hidden');
                    emptyEl.classList.add('flex');
                }
            })
            .catch(function(err) {
                console.error('Chat delete error:', err);
                alert('Hindi na-delete ang message. Subukan ulit.');
            });
        };

        fetchMessages();
        var chatPollInterval = setInterval(fetchMessages, 3000);
    });
    </script>
    <?php endif; ?>

    
    <?php
        $toastMessages = [];
        if (session('success')) $toastMessages[] = ['type' => 'success', 'message' => session('success')];
        if (session('error'))   $toastMessages[] = ['type' => 'error',   'message' => session('error')];
        if (session('info'))    $toastMessages[] = ['type' => 'info',    'message' => session('info')];
        if (session('warning')) $toastMessages[] = ['type' => 'warning', 'message' => session('warning')];
        if ($errors->any()) {
            foreach ($errors->all() as $err) {
                $toastMessages[] = ['type' => 'error', 'message' => $err];
            }
        }
    ?>
    <script id="mv-toast-data" type="application/json"><?php echo json_encode($toastMessages, 15, 512) ?></script>
    <script>
    (function() {
        var container = document.getElementById('mv-toast-container');

        var icons = {
            success: '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
            error:   '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
            info:    '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
            warning: '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" /></svg>'
        };

        var titles = {
            success: 'Success',
            error: 'Error',
            info: 'Info',
            warning: 'Warning'
        };

        var textColors = {
            success: 'color:#065f46',
            error:   'color:#991b1b',
            info:    'color:#1e40af',
            warning: 'color:#92400e'
        };
        var darkTextColors = {
            success: 'color:#a7f3d0',
            error:   'color:#fecaca',
            info:    'color:#bfdbfe',
            warning: 'color:#fde68a'
        };

        function isDark() {
            return document.documentElement.classList.contains('dark');
        }

        function escapeHtml(str) {
            var div = document.createElement('div');
            div.textContent = str;
            return div.innerHTML;
        }

        /**
         * Show a toast notification.
         * @param {string} type    - success | error | info | warning
         * @param {string} message - The message to display
         * @param {number} duration - Auto-dismiss in ms (default 5000)
         */
        window.mvToast = function(type, message, duration) {
            if (!container) return;
            duration = duration || 5000;

            var toast = document.createElement('div');
            toast.className = 'mv-toast mv-toast--' + type;
            toast.style.position = 'relative';
            toast.style.overflow = 'hidden';

            var tColors = isDark() ? darkTextColors : textColors;

            toast.innerHTML =
                '<div class="mv-toast-icon flex-shrink-0 mt-0.5">' + (icons[type] || icons.info) + '</div>' +
                '<div class="flex-1 min-w-0">' +
                    '<p style="font-size:0.8125rem;font-weight:700;margin:0;' + (tColors[type] || '') + '">' + escapeHtml(titles[type] || 'Notification') + '</p>' +
                    '<p style="font-size:0.8125rem;margin:0.125rem 0 0;' + (tColors[type] || '') + ';opacity:0.85">' + escapeHtml(message) + '</p>' +
                '</div>' +
                '<button type="button" class="mv-toast-close flex-shrink-0 mt-0.5" style="background:none;border:none;cursor:pointer;padding:0.25rem;border-radius:0.375rem;opacity:0.5;transition:opacity 0.2s">' +
                    '<svg xmlns="http://www.w3.org/2000/svg" style="width:1rem;height:1rem;' + (tColors[type] || '') + '" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>' +
                '</button>' +
                '<div class="mv-toast-progress" style="animation-duration:' + duration + 'ms"></div>';

            // Close button
            toast.querySelector('.mv-toast-close').addEventListener('click', function() {
                dismissToast(toast);
            });
            toast.querySelector('.mv-toast-close').addEventListener('mouseenter', function() {
                this.style.opacity = '1';
            });
            toast.querySelector('.mv-toast-close').addEventListener('mouseleave', function() {
                this.style.opacity = '0.5';
            });

            container.appendChild(toast);

            // Auto-dismiss
            var timer = setTimeout(function() { dismissToast(toast); }, duration);

            // Pause on hover
            toast.addEventListener('mouseenter', function() {
                clearTimeout(timer);
                var bar = toast.querySelector('.mv-toast-progress');
                if (bar) bar.style.animationPlayState = 'paused';
            });
            toast.addEventListener('mouseleave', function() {
                var bar = toast.querySelector('.mv-toast-progress');
                if (bar) bar.style.animationPlayState = 'running';
                timer = setTimeout(function() { dismissToast(toast); }, 2000);
            });
        };

        function dismissToast(toast) {
            if (toast.classList.contains('mv-toast-exit')) return;
            toast.classList.add('mv-toast-exit');
            setTimeout(function() {
                if (toast.parentNode) toast.parentNode.removeChild(toast);
            }, 400);
        }

        // Fire initial toasts from session flash data
        var dataEl = document.getElementById('mv-toast-data');
        if (dataEl) {
            try {
                var messages = JSON.parse(dataEl.textContent || '[]');
                messages.forEach(function(item, i) {
                    setTimeout(function() {
                        window.mvToast(item.type, item.message);
                    }, i * 150);
                });
            } catch (e) {}
        }
    })();
    </script>

    <?php echo $__env->yieldPushContent('modals'); ?>
</body>
</html><?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views\layouts\app.blade.php ENDPATH**/ ?>