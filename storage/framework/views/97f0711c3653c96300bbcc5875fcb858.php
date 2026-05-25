<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role Login Launcher</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css']); ?>
</head>
<body class="min-h-screen bg-slate-50 dark:bg-slate-900" style="font-family: 'Inter', sans-serif;">
    <div class="mx-auto max-w-5xl px-4 py-10">
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-100">Role Login Launcher</h1>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Choose your role to continue to the correct login page.</p>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-6">
            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $label = match ($role) {
                        'project_manager' => 'Project Manager',
                        'lead' => 'Team Lead',
                        default => str($role)->replace('_', ' ')->title()->toString(),
                    };
                    $gradient = match ($role) {
                        'admin' => 'from-rose-400 to-red-500',
                        'member' => 'from-cyan-400 to-blue-500',
                        'manager' => 'from-sky-400 to-blue-500',
                        'project_manager' => 'from-indigo-400 to-violet-500',
                        'executive' => 'from-amber-400 to-orange-500',
                        'lead' => 'from-emerald-400 to-teal-500',
                        default => 'from-slate-400 to-slate-500',
                    };
                ?>
                <a href="<?php echo e(route('role.login.show', ['role' => str_replace('_', '-', $role)])); ?>"
                   class="rounded-2xl bg-gradient-to-br <?php echo e($gradient); ?> p-5 text-white shadow-lg transition hover:-translate-y-0.5 hover:shadow-xl">
                    <p class="text-xs uppercase tracking-wide opacity-90">Login</p>
                    <p class="mt-2 text-lg font-semibold"><?php echo e($label); ?></p>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="mt-8 text-center text-sm text-slate-500 dark:text-slate-400">
            Default login is still available at
            <a href="/login" class="text-blue-600 hover:underline">/login</a>.
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views\auth\role-login-launcher.blade.php ENDPATH**/ ?>