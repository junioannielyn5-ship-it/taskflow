<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email Test Result</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css']); ?>
</head>
<body class="min-h-screen bg-slate-100">
    <div class="mx-auto flex min-h-screen max-w-3xl items-center px-4 py-8">
        <div class="w-full rounded-2xl bg-white p-6 shadow-xl md:p-8">
            <div class="mb-5 flex items-center justify-between">
                <h1 class="text-2xl font-bold text-slate-800">Email Test</h1>
                <span class="rounded-full px-3 py-1 text-xs font-semibold <?php echo e($status === 'ok' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700'); ?>">
                    <?php echo e(strtoupper($status)); ?>

                </span>
            </div>

            <p class="mb-4 text-sm text-slate-600"><?php echo e($message); ?></p>

            <div class="space-y-2 rounded-xl border border-slate-200 bg-slate-50 p-4">
                <p class="text-sm text-slate-700"><span class="font-semibold">Recipient:</span> <?php echo e($to); ?></p>
                <p class="text-sm text-slate-700"><span class="font-semibold">Timestamp:</span> <?php echo e(now()->format('M d, Y h:i A')); ?></p>
            </div>

            <?php if(!empty($error)): ?>
                <div class="mt-4 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
                    <p class="font-semibold">Error details</p>
                    <p class="mt-1 break-words"><?php echo e($error); ?></p>
                </div>
            <?php endif; ?>

            <div class="mt-6 flex flex-wrap gap-2">
                <a href="<?php echo e(url('/email')); ?>" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">Back to Email Alerts</a>
                <a href="<?php echo e(route('dashboard')); ?>" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Go to Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views\dev\test-email-result.blade.php ENDPATH**/ ?>