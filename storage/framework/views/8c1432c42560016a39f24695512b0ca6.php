<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <section class="rounded-2xl border border-violet-200 dark:border-violet-800 bg-gradient-to-r from-violet-50 to-indigo-50 dark:from-violet-900/30 dark:to-indigo-900/30 p-5 shadow-sm">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Chatbot Knowledge Manager</h1>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Manage chatbot answers directly from the database. Supports English and Filipino.</p>
    </section>

    <?php if(session('success')): ?>
        <div class="rounded-xl border border-emerald-200 dark:border-emerald-800 bg-emerald-50 dark:bg-emerald-900/30 px-4 py-3 text-sm text-emerald-700 dark:text-emerald-300">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="rounded-xl border border-rose-200 dark:border-rose-800 bg-rose-50 dark:bg-rose-900/30 px-4 py-3 text-sm text-rose-700 dark:text-rose-300">
            <?php echo e($errors->first()); ?>

        </div>
    <?php endif; ?>

    <section class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm">
        <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Add Knowledge</h2>
        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Links format per line: <code class="dark:text-slate-300">Label|/path</code></p>

        <form method="POST" action="<?php echo e(route('admin.chatbot.store')); ?>" class="mt-4 grid grid-cols-1 gap-3 md:grid-cols-2">
            <?php echo csrf_field(); ?>

            <div>
                <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Language</label>
                <select name="language" class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100">
                    <option value="en">English</option>
                    <option value="fil">Filipino</option>
                </select>
            </div>

            <div>
                <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Intent</label>
                <input name="intent" required class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500" placeholder="create_task">
            </div>

            <div class="md:col-span-2">
                <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Title</label>
                <input name="title" required class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500" placeholder="Create Task (Step by Step)">
            </div>

            <div class="md:col-span-2">
                <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Summary</label>
                <textarea name="summary" rows="2" required class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500" placeholder="Short answer summary"></textarea>
            </div>

            <div>
                <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Steps (one per line)</label>
                <textarea name="steps" rows="5" class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500" placeholder="Step 1&#10;Step 2"></textarea>
            </div>

            <div>
                <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Keywords (comma-separated)</label>
                <textarea name="keywords" rows="5" class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500" placeholder="create task, new task, task step"></textarea>
            </div>

            <div>
                <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Links (one per line)</label>
                <textarea name="links" rows="4" class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500" placeholder="Dashboard|/dashboard&#10;Tasks|/tasks"></textarea>
            </div>

            <div>
                <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Sort Order</label>
                <input name="sort_order" type="number" value="100" class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100">
                <label class="mt-2 inline-flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300">
                    <input type="checkbox" name="is_active" value="1" checked class="dark:bg-slate-700 dark:border-slate-600">
                    Active
                </label>
            </div>

            <div class="md:col-span-2">
                <button type="submit" class="rounded-lg bg-violet-600 px-4 py-2 text-sm font-semibold text-white hover:bg-violet-700 dark:bg-violet-500 dark:hover:bg-violet-600">Add Knowledge</button>
            </div>
        </form>
    </section>

    <section class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm">
        <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Existing Knowledge</h2>

        <div class="mt-4 space-y-4">
            <?php $__empty_1 = true; $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="rounded-xl border border-slate-200 dark:border-slate-700 p-4">
                    <form method="POST" action="<?php echo e(route('admin.chatbot.update', $record)); ?>" class="grid grid-cols-1 gap-3 md:grid-cols-2">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Language</label>
                            <select name="language" class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100">
                                <option value="en" <?php if($record->language === 'en'): echo 'selected'; endif; ?>>English</option>
                                <option value="fil" <?php if($record->language === 'fil'): echo 'selected'; endif; ?>>Filipino</option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Intent</label>
                            <input name="intent" required value="<?php echo e($record->intent); ?>" class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100">
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Title</label>
                            <input name="title" required value="<?php echo e($record->title); ?>" class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100">
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Summary</label>
                            <textarea name="summary" rows="2" required class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100"><?php echo e($record->summary); ?></textarea>
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Steps (one per line)</label>
                            <textarea name="steps" rows="5" class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100"><?php echo e(collect($record->steps ?? [])->implode("\n")); ?></textarea>
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Keywords (comma-separated)</label>
                            <textarea name="keywords" rows="5" class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100"><?php echo e(collect($record->keywords ?? [])->implode(', ')); ?></textarea>
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Links (one per line)</label>
                            <textarea name="links" rows="4" class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100"><?php echo e(collect($record->links ?? [])->map(fn($link) => (($link['label'] ?? '') . '|' . ($link['path'] ?? '')))->implode("\n")); ?></textarea>
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Sort Order</label>
                            <input name="sort_order" type="number" value="<?php echo e($record->sort_order); ?>" class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100">
                            <label class="mt-2 inline-flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300">
                                <input type="checkbox" name="is_active" value="1" <?php if($record->is_active): echo 'checked'; endif; ?> class="dark:bg-slate-700 dark:border-slate-600">
                                Active
                            </label>
                        </div>

                        <div class="md:col-span-2 flex flex-wrap gap-2">
                            <button type="submit" class="rounded-lg bg-violet-600 px-4 py-2 text-sm font-semibold text-white hover:bg-violet-700 dark:bg-violet-500 dark:hover:bg-violet-600">Save</button>
                    </form>
                            <form method="POST" action="<?php echo e(route('admin.chatbot.destroy', $record)); ?>" onsubmit="return confirm('Delete this knowledge item?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="rounded-lg border border-rose-300 dark:border-rose-700 bg-rose-50 dark:bg-rose-900/30 px-4 py-2 text-sm font-semibold text-rose-700 dark:text-rose-400 hover:bg-rose-100 dark:hover:bg-rose-900/50">Delete</button>
                            </form>
                        </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-sm text-slate-500 dark:text-slate-400">No chatbot knowledge records found.</p>
            <?php endif; ?>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views\admin\chatbot-knowledge.blade.php ENDPATH**/ ?>