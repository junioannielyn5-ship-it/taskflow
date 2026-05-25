<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($roleLabel); ?> Login — Movaflex</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css']); ?>
</head>
<body class="m-0 min-h-screen bg-[#04111d]" style="font-family: 'Inter', sans-serif;">


<div class="relative flex min-h-screen items-center justify-center px-4 py-8 md:px-10">
    
    <div class="pointer-events-none absolute -top-40 -left-40 h-[500px] w-[500px] rounded-full bg-cyan-500/15 blur-[120px]"></div>
    <div class="pointer-events-none absolute top-1/4 right-0 h-96 w-96 rounded-full bg-teal-500/10 blur-[100px]"></div>
    <div class="pointer-events-none absolute right-1/3 bottom-0 h-[450px] w-[450px] rounded-full bg-emerald-500/10 blur-[120px]"></div>

    <div class="relative mx-auto grid w-full max-w-[1100px] overflow-hidden rounded-[2rem] border border-white/[0.06] shadow-2xl shadow-black/50 lg:grid-cols-[1.25fr_1fr]">

        
        <div class="relative hidden overflow-hidden bg-gradient-to-br from-[#071e30] via-[#0b2a44] to-[#0e3555] p-10 text-slate-100 lg:flex lg:flex-col lg:p-14">
            
            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_20%_10%,rgba(6,182,212,0.12)_0%,transparent_60%)]"></div>
            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_80%_90%,rgba(16,185,129,0.08)_0%,transparent_60%)]"></div>

            
            <div class="flex justify-center">
                <a href="/" class="group inline-block transition-transform duration-300 hover:scale-105">
                    <div class="relative flex items-center justify-center">
                        <div class="absolute h-32 w-32 rounded-full bg-white dark:bg-slate-900 opacity-50 blur-xl"></div>
                        <img src="<?php echo e(asset('images/movaflex-logo-official.png')); ?>" alt="Movaflex Logo" class="relative z-10 h-24 w-auto object-contain">
                    </div>
                </a>
            </div>

            <p class="mt-2 text-center text-[10px] font-bold uppercase tracking-[0.4em] text-cyan-400/80">Task Management System</p>

            <div class="mx-auto mt-6 h-px w-24 bg-gradient-to-r from-transparent via-cyan-400/40 to-transparent"></div>

            <div class="mt-8 space-y-4 text-center">
                <h1 class="text-2xl font-extrabold leading-snug tracking-tight text-white md:text-3xl">
                    Where Focus Meets
                    <span class="bg-gradient-to-r from-cyan-300 via-teal-300 to-emerald-300 bg-clip-text text-transparent">Execution</span>
                </h1>
                <p class="mx-auto max-w-sm text-[13px] leading-relaxed text-slate-400 dark:text-slate-500 dark:text-slate-400">
                    Plan, deliver, and stay accountable — all in one streamlined platform with timelines, approvals, and smart reporting.
                </p>
            </div>

            
            <div class="mt-8 grid gap-2.5 sm:grid-cols-3">
                <div class="rounded-xl border border-cyan-400/15 bg-cyan-500/[0.06] px-4 py-3.5 text-center transition-all hover:border-cyan-400/30 hover:bg-cyan-500/[0.1]">
                    <div class="mx-auto mb-1.5 flex h-8 w-8 items-center justify-center rounded-lg bg-cyan-400/10">
                        <svg class="h-4 w-4 text-cyan-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                    </div>
                    <p class="text-sm font-bold text-cyan-200">Tasks</p>
                    <p class="mt-0.5 text-[10px] text-cyan-100/50">Unified board</p>
                </div>
                <div class="rounded-xl border border-emerald-400/15 bg-emerald-500/[0.06] px-4 py-3.5 text-center transition-all hover:border-emerald-400/30 hover:bg-emerald-500/[0.1]">
                    <div class="mx-auto mb-1.5 flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-400/10">
                        <svg class="h-4 w-4 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                    </div>
                    <p class="text-sm font-bold text-emerald-200">Approvals</p>
                    <p class="mt-0.5 text-[10px] text-emerald-100/50">Checkpoints</p>
                </div>
                <div class="rounded-xl border border-amber-400/15 bg-amber-500/[0.06] px-4 py-3.5 text-center transition-all hover:border-amber-400/30 hover:bg-amber-500/[0.1]">
                    <div class="mx-auto mb-1.5 flex h-8 w-8 items-center justify-center rounded-lg bg-amber-400/10">
                        <svg class="h-4 w-4 text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    </div>
                    <p class="text-sm font-bold text-amber-200">Insights</p>
                    <p class="mt-0.5 text-[10px] text-amber-100/50">Reports</p>
                </div>
            </div>

            
            <div class="mt-auto pt-8">
                <div class="mx-auto h-px w-16 bg-gradient-to-r from-transparent via-slate-500/20 to-transparent"></div>
                <p class="mt-3 text-center text-[10px] text-slate-500 dark:text-slate-400/50">&copy; <?php echo e(date('Y')); ?> Movaflex Designs Unlimited Inc.</p>
            </div>
        </div>

        
        <div class="relative flex flex-col justify-center bg-white dark:bg-slate-900 p-8 md:p-10 lg:p-12">
            <div class="pointer-events-none absolute top-0 right-0 h-32 w-32 bg-gradient-to-bl from-cyan-50 to-transparent opacity-60"></div>

            <div class="relative mx-auto w-full max-w-sm">
                
                <div class="mb-6 flex justify-center lg:hidden">
                    <img src="<?php echo e(asset('images/movaflex-logo-official.png')); ?>" alt="Movaflex Logo" class="h-16 w-auto">
                </div>

                <div class="mb-8">
                    <h2 class="text-2xl font-extrabold tracking-tight text-slate-800 dark:text-slate-100"><?php echo e($roleLabel); ?> Login</h2>
                    <p class="mt-1 text-sm text-slate-400 dark:text-slate-500 dark:text-slate-400">Sign in with your <?php echo e($roleLabel); ?> account to continue.</p>
                </div>

                <?php if($errors->any()): ?>
                    <div class="mb-5 rounded-xl border border-rose-200 dark:border-rose-800 bg-rose-50 dark:bg-rose-900/30 px-4 py-3 text-sm font-medium text-rose-700 dark:text-rose-400">
                        <?php echo e($errors->first()); ?>

                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('role.login.attempt', ['role' => $role])); ?>" class="space-y-5">
                    <?php echo csrf_field(); ?>

                    <div>
                        <label for="email" class="mb-1.5 block text-[13px] font-semibold text-slate-700 dark:text-slate-300">Email address</label>
                        <input id="email" name="email" type="email" required autofocus autocomplete="email" value="<?php echo e(old('email')); ?>"
                               placeholder="you@company.com"
                               class="h-11 w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/80 dark:bg-slate-800 px-4 text-sm text-slate-900 dark:text-slate-100 placeholder:text-slate-400 dark:text-slate-500 dark:text-slate-400 transition-all focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
                    </div>

                    <div>
                        <div class="mb-1.5 flex items-center justify-between">
                            <label for="password" class="text-[13px] font-semibold text-slate-700 dark:text-slate-300">Password</label>
                            <a href="<?php echo e(route('password.request')); ?>" class="text-[11px] font-semibold tracking-wide text-indigo-600 hover:text-indigo-800">Forgot password?</a>
                        </div>
                        <input id="password" name="password" type="password" required autocomplete="current-password"
                               placeholder="Password"
                               class="h-11 w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/80 dark:bg-slate-800 px-4 text-sm text-slate-900 dark:text-slate-100 placeholder:text-slate-400 dark:text-slate-500 dark:text-slate-400 transition-all focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
                    </div>

                    <label class="flex items-center gap-2.5 text-sm text-slate-500 dark:text-slate-400">
                        <input type="checkbox" name="remember" value="1" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        Keep me signed in
                    </label>

                    <button type="submit" class="h-11 w-full rounded-xl bg-slate-900 text-sm font-semibold text-white shadow-lg shadow-slate-900/20 transition-all hover:bg-slate-800 hover:shadow-xl active:scale-[0.98]">
                        Sign in
                    </button>
                </form>

                <div class="mt-6 border-t border-slate-100 dark:border-slate-800 pt-4">
                    <a href="<?php echo e(route('role.login.launcher')); ?>" class="inline-flex items-center gap-1.5 text-xs font-medium text-indigo-600 hover:text-indigo-800 transition">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                        Back to role launcher
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>
<?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views\auth\role-login.blade.php ENDPATH**/ ?>