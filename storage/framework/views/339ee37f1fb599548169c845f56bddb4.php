

<?php $__env->startSection('content'); ?>
<div class="space-y-6">

    
    <div class="mv-card inline-flex w-fit rounded-2xl border border-white/30 bg-white/95 px-4 py-2 shadow-xl dark:bg-slate-800 dark:border-slate-700">
        <p class="text-2xl font-bold uppercase tracking-wide text-slate-700 md:text-3xl dark:text-white">Audit Log Timeline</p>
    </div>

    
    <form method="GET" action="<?php echo e(route('audit-logs.index')); ?>">
        <div class="flex flex-wrap items-end gap-4 rounded-2xl border border-white/30 bg-white/95 px-6 py-4 shadow-xl dark:bg-slate-800 dark:border-slate-700">
            <div>
                <label for="search" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Search</label>
                <input type="text" id="search" name="search" value="<?php echo e(request('search')); ?>"
                    class="rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-teal-500 focus:ring-teal-500 dark:border-slate-600 dark:bg-slate-900 dark:text-white"
                    placeholder="User, task no...">
            </div>
            <div>
                <label for="action" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Action</label>
                <select id="action" name="action" class="rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-teal-500 focus:ring-teal-500 dark:border-slate-600 dark:bg-slate-900 dark:text-white">
                    <option value="">All actions</option>
                    <option value="Created" <?php echo e(request('action') === 'Created' ? 'selected' : ''); ?>>Created</option>
                    <option value="Updated" <?php echo e(request('action') === 'Updated' ? 'selected' : ''); ?>>Updated</option>
                    <option value="Deleted" <?php echo e(request('action') === 'Deleted' ? 'selected' : ''); ?>>Deleted</option>
                    <option value="Restored" <?php echo e(request('action') === 'Restored' ? 'selected' : ''); ?>>Restored</option>
                </select>
            </div>
            <div>
                <label for="model_type" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Type</label>
                <select id="model_type" name="model_type" class="rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-teal-500 focus:ring-teal-500 dark:border-slate-600 dark:bg-slate-900 dark:text-white">
                    <option value="">All types</option>
                    <option value="task" <?php echo e(request('model_type') === 'task' ? 'selected' : ''); ?>>Task</option>
                    <option value="project" <?php echo e(request('model_type') === 'project' ? 'selected' : ''); ?>>Project</option>
                </select>
            </div>
            <div>
                <label for="user_id" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">User</label>
                <select id="user_id" name="user_id" class="rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-teal-500 focus:ring-teal-500 dark:border-slate-600 dark:bg-slate-900 dark:text-white">
                    <option value="">All users</option>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($user->id); ?>" <?php echo e(request('user_id') == $user->id ? 'selected' : ''); ?>><?php echo e($user->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="rounded-lg bg-teal-700 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-800">Apply</button>
                <a href="<?php echo e(route('audit-logs.index')); ?>" class="rounded border border-gray-300 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700">Clear</a>
            </div>
        </div>
    </form>

    
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm dark:bg-slate-800 dark:border-slate-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
            <h3 class="text-lg font-extrabold text-slate-800 flex items-center gap-2 dark:text-white">
                <span class="p-2 bg-blue-50 text-blue-600 rounded-lg dark:bg-blue-900/40 dark:text-blue-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                Activity Audit Log
            </h3>
            <span class="text-xs font-medium text-slate-400"><?php echo e($auditLogs->total()); ?> total entries</span>
        </div>

        <?php if($auditLogs->isEmpty()): ?>
            <div class="px-6 py-8 text-center text-gray-600 dark:text-slate-400">
                No audit log entries found.
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 dark:bg-slate-900/50 text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400 border-b-2 border-slate-200 dark:border-slate-600">
                        <tr class="divide-x divide-slate-200 dark:divide-slate-600">
                            <th class="px-6 py-3 font-semibold">User</th>
                            <th class="px-6 py-3 font-semibold">Action</th>
                            <th class="px-6 py-3 font-semibold">Type</th>
                            <th class="px-6 py-3 font-semibold">Reference</th>
                            <th class="px-6 py-3 font-semibold">Details</th>
                            <th class="px-6 py-3 font-semibold">Date</th>
                            <th class="px-6 py-3 font-semibold">IP</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-600">
                        <?php $__currentLoopData = $auditLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="divide-x divide-slate-200 dark:divide-slate-600 hover:bg-transparent transition-colors">
                            <td class="px-6 py-3 font-semibold text-slate-800 dark:text-slate-200 whitespace-nowrap">
                                <?php echo e($log->user->name ?? 'System'); ?>

                            </td>
                            <td class="px-6 py-3">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[11px] font-bold
                                    <?php if($log->action === 'Created'): ?> bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400
                                    <?php elseif($log->action === 'Updated'): ?> bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400
                                    <?php elseif($log->action === 'Restored'): ?> bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400
                                    <?php else: ?> bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-400
                                    <?php endif; ?>
                                "><?php echo e($log->action); ?></span>
                            </td>
                            <td class="px-6 py-3 text-slate-600 dark:text-slate-300">
                                <?php echo e(class_basename($log->model_type)); ?>

                            </td>
                            <td class="px-6 py-3">
                                <span class="font-mono bg-slate-100 px-2 py-0.5 rounded text-blue-700 text-xs dark:bg-slate-700 dark:text-blue-400"><?php echo e($log->model_label ?? '#' . $log->model_id); ?></span>
                            </td>
                            <td class="px-6 py-3 text-xs text-slate-500 dark:text-slate-400 max-w-xs">
                                <?php if($log->action === 'Updated' && !empty($log->new_values)): ?>
                                    <?php $__currentLoopData = $log->new_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $newVal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $oldVal = $log->old_values[$field] ?? '—';
                                            $fieldLabel = ucwords(str_replace('_', ' ', $field));
                                        ?>
                                        <div class="mb-1">
                                            <span class="font-semibold text-slate-700 dark:text-slate-300"><?php echo e($fieldLabel); ?></span>:
                                            <span class="text-amber-600 dark:text-amber-400">"<?php echo e(\Illuminate\Support\Str::limit($oldVal, 40)); ?>"</span>
                                            → <span class="text-emerald-600 dark:text-emerald-400">"<?php echo e(\Illuminate\Support\Str::limit($newVal, 40)); ?>"</span>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php elseif($log->action === 'Created' && !empty($log->new_values)): ?>
                                    <?php
                                        $showFields = array_intersect_key($log->new_values, array_flip(['title', 'task_no', 'name', 'status', 'priority']));
                                    ?>
                                    <?php $__currentLoopData = $showFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 dark:bg-emerald-900/30 px-2 py-0.5 text-[11px] font-medium text-emerald-700 dark:text-emerald-400 mr-1 mb-1">
                                            <?php echo e(ucwords(str_replace('_', ' ', $field))); ?>: <?php echo e(\Illuminate\Support\Str::limit($val, 30)); ?>

                                        </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <span class="text-slate-400">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-3 text-slate-500 dark:text-slate-400 whitespace-nowrap text-xs">
                                <?php echo e($log->created_at->format('M d, Y h:i A')); ?>

                            </td>
                            <td class="px-6 py-3 text-slate-400 whitespace-nowrap text-xs font-mono">
                                <?php echo e($log->ip_address ?? '—'); ?>

                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            
            <?php if($auditLogs->hasPages()): ?>
                <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700">
                    <?php echo e($auditLogs->links()); ?>

                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views/audit-logs/index.blade.php ENDPATH**/ ?>