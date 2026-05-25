

<?php $__env->startSection('content'); ?>
<div class="relative space-y-6">
    <!-- Dynamic Background Effects -->
    <div class="pointer-events-none absolute right-0 top-0 h-[500px] w-[500px] -translate-y-1/3 translate-x-1/3 rounded-full bg-gradient-to-br from-blue-500/20 to-purple-500/20 blur-[80px] dark:from-blue-600/20 dark:to-purple-600/20"></div>
    <div class="pointer-events-none absolute bottom-0 left-0 h-[400px] w-[400px] -translate-x-1/3 translate-y-1/3 rounded-full bg-gradient-to-tr from-emerald-500/20 to-cyan-500/20 blur-[80px] dark:from-emerald-600/20 dark:to-cyan-600/20"></div>

    
    <div class="relative flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between mb-8">
        <div>
            <div class="mb-2 inline-flex items-center rounded-full border border-blue-200/50 bg-blue-50/50 px-3 py-1 text-xs font-semibold tracking-wide text-blue-700 shadow-sm backdrop-blur-md dark:border-blue-700/50 dark:bg-blue-900/50 dark:text-blue-300">
                <span class="mr-1.5 flex h-2 w-2 rounded-full bg-blue-500"></span>
                System Logs
            </div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white md:text-4xl lg:text-5xl">
                Audit <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent dark:from-blue-400 dark:to-indigo-400">Log</span>
            </h1>
        </div>
    </div>

    
    <form method="GET" action="<?php echo e(route('audit-logs.index')); ?>">
        <div class="relative flex flex-wrap items-end gap-5 rounded-2xl border border-white/40 bg-white/40 px-6 py-5 shadow-lg backdrop-blur-xl dark:border-slate-700/50 dark:bg-slate-800/40 mb-6">
            <div class="flex-grow md:flex-grow-0">
                <label for="search" class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-slate-600 dark:text-slate-400">Search Keywords</label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <input type="text" id="search" name="search" value="<?php echo e(request('search')); ?>"
                        class="block w-full rounded-xl border-0 bg-white/70 py-2.5 pl-10 text-sm font-medium text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300/50 backdrop-blur-sm transition-all focus:bg-white focus:ring-2 focus:ring-inset focus:ring-blue-500 dark:bg-slate-900/50 dark:text-white dark:ring-slate-700/50 dark:focus:bg-slate-800 dark:focus:ring-blue-500 placeholder:text-slate-400"
                        placeholder="User, task no...">
                </div>
            </div>
            <div>
                <label for="action" class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-slate-600 dark:text-slate-400">Action</label>
                <select id="action" name="action" class="block w-full rounded-xl border-0 bg-white/70 py-2.5 px-3 text-sm font-medium text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300/50 backdrop-blur-sm transition-all focus:bg-white focus:ring-2 focus:ring-inset focus:ring-blue-500 dark:bg-slate-900/50 dark:text-white dark:ring-slate-700/50 dark:focus:bg-slate-800 dark:focus:ring-blue-500">
                    <option value="">All actions</option>
                    <option value="Created" <?php echo e(request('action') === 'Created' ? 'selected' : ''); ?>>Created</option>
                    <option value="Updated" <?php echo e(request('action') === 'Updated' ? 'selected' : ''); ?>>Updated</option>
                    <option value="Deleted" <?php echo e(request('action') === 'Deleted' ? 'selected' : ''); ?>>Deleted</option>
                    <option value="Restored" <?php echo e(request('action') === 'Restored' ? 'selected' : ''); ?>>Restored</option>
                </select>
            </div>
            <div>
                 <label for="model_type" class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-slate-600 dark:text-slate-400">Type</label>
                 <select id="model_type" name="model_type" class="block w-full rounded-xl border-0 bg-white/70 py-2.5 px-3 text-sm font-medium text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300/50 backdrop-blur-sm transition-all focus:bg-white focus:ring-2 focus:ring-inset focus:ring-blue-500 dark:bg-slate-900/50 dark:text-white dark:ring-slate-700/50 dark:focus:bg-slate-800 dark:focus:ring-blue-500">
                    <option value="">All types</option>
                    <option value="task" <?php echo e(request('model_type') === 'task' ? 'selected' : ''); ?>>Task</option>
                    <option value="project" <?php echo e(request('model_type') === 'project' ? 'selected' : ''); ?>>Project</option>
                </select>
            </div>
            <div>
                 <label for="user_id" class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-slate-600 dark:text-slate-400">User</label>
                 <select id="user_id" name="user_id" class="block w-full rounded-xl border-0 bg-white/70 py-2.5 px-3 text-sm font-medium text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300/50 backdrop-blur-sm transition-all focus:bg-white focus:ring-2 focus:ring-inset focus:ring-blue-500 dark:bg-slate-900/50 dark:text-white dark:ring-slate-700/50 dark:focus:bg-slate-800 dark:focus:ring-blue-500">
                    <option value="">All users</option>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($user->id); ?>" <?php echo e(request('user_id') == $user->id ? 'selected' : ''); ?>><?php echo e($user->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="flex flex-1 items-end justify-end gap-3">
                <a href="<?php echo e(route('audit-logs.index')); ?>" class="inline-flex items-center justify-center rounded-xl px-5 py-2.5 text-sm font-bold text-slate-600 transition-colors hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-700/50 dark:hover:text-white">Clear Filters</a>
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-2.5 text-sm font-bold text-white shadow-md shadow-blue-500/20 transition-all hover:scale-105 hover:from-blue-500 hover:to-indigo-500 hover:shadow-lg hover:shadow-blue-500/40">Apply</button>
            </div>
        </div>
    </form>

    
    <div class="overflow-x-auto rounded-2xl border border-white/40 bg-white/60 shadow-xl backdrop-blur-xl dark:border-slate-700/50 dark:bg-slate-800/60 dark:shadow-slate-900/50">
        <div class="px-6 py-5 border-b border-slate-200/50 dark:border-slate-700/50 flex items-center justify-between">
            <h3 class="text-lg font-extrabold text-slate-800 dark:text-slate-100 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-600 shadow-inner dark:bg-blue-900/50 dark:text-blue-400">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                Audit Trail
            </h3>
            <span class="rounded-full bg-slate-200/50 px-3 py-1 text-xs font-semibold text-slate-600 dark:bg-slate-700/50 dark:text-slate-300"><?php echo e($auditLogs->total()); ?> total entries</span>
        </div>

        <?php if($auditLogs->isEmpty()): ?>
            <div class="flex flex-col items-center justify-center px-6 py-16 text-center">
                <div class="mb-4 rounded-full bg-slate-100/50 p-4 dark:bg-slate-800/30">
                    <svg class="h-10 w-10 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">No audit entries found</h3>
                <p class="mt-1 max-w-sm text-sm text-slate-500 dark:text-slate-400">There is no log data matching your current filters.</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50/50 dark:bg-slate-800/50 backdrop-blur-md text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200/50 dark:border-slate-700/50">
                        <tr class="divide-x divide-slate-200/30 dark:divide-slate-700/30">
                            <th class="px-6 py-3.5">User</th>
                            <th class="px-6 py-3.5">Action</th>
                            <th class="px-6 py-3.5">Type</th>
                            <th class="px-6 py-3.5">Reference</th>
                            <th class="px-6 py-3.5">Details</th>
                            <th class="px-6 py-3.5">Date</th>
                            <th class="px-6 py-3.5">IP</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/30 bg-transparent">
                        <?php $__currentLoopData = $auditLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="divide-x divide-slate-100 dark:divide-slate-700/30 hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors duration-200">
                            <td class="px-6 py-4 font-bold text-slate-800 dark:text-slate-100 whitespace-nowrap">
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
                            <td class="px-6 py-4 text-xs font-semibold text-slate-600 dark:text-slate-300">
                                <?php echo e(class_basename($log->model_type)); ?>

                            </td>
                            <td class="px-6 py-4">
                                <span class="font-mono bg-slate-100 dark:bg-white/10 px-2 py-0.5 rounded text-blue-600 dark:text-[#93C5FD] text-xs border border-slate-200 dark:border-white/15"><?php echo e($log->model_label ?? '#' . $log->model_id); ?></span>
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-600 dark:text-slate-300 max-w-xs leading-relaxed">
                                <?php if($log->action === 'Updated' && !empty($log->new_values)): ?>
                                    <?php $__currentLoopData = $log->new_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $newVal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $oldVal = $log->old_values[$field] ?? '—';
                                            $fieldLabel = ucwords(str_replace('_', ' ', $field));
                                        ?>
                                        <div class="mb-1">
                                            <span class="font-semibold text-slate-700 dark:text-slate-200"><?php echo e($fieldLabel); ?></span>:
                                            <span class="text-amber-600 dark:text-amber-300">"<?php echo e(\Illuminate\Support\Str::limit($oldVal, 40)); ?>"</span>
                                            → <span class="text-emerald-600 dark:text-emerald-300">"<?php echo e(\Illuminate\Support\Str::limit($newVal, 40)); ?>"</span>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php elseif($log->action === 'Created' && !empty($log->new_values)): ?>
                                    <?php
                                        $showFields = array_intersect_key($log->new_values, array_flip(['title', 'task_no', 'name', 'status', 'priority']));
                                    ?>
                                    <?php $__currentLoopData = $showFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="inline-flex items-center rounded-full bg-emerald-100 dark:bg-emerald-500/20 border border-emerald-300 dark:border-emerald-400/35 px-2 py-0.5 text-[11px] font-medium text-emerald-700 dark:text-emerald-300 mr-1 mb-1">
                                            <?php echo e(ucwords(str_replace('_', ' ', $field))); ?>: <?php echo e(\Illuminate\Support\Str::limit($val, 30)); ?>

                                        </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <span class="text-slate-500">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-slate-500 dark:text-slate-400 whitespace-nowrap text-xs font-medium">
                                <?php echo e($log->created_at->format('M d, Y h:i A')); ?>

                            </td>
                            <td class="px-6 py-4 text-slate-400 dark:text-slate-500 whitespace-nowrap text-xs font-mono">
                                <?php echo e($log->ip_address ?? '—'); ?>

                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            
            <div class="px-6 py-4 border-t border-slate-200/50 dark:border-slate-700/50 flex flex-col items-center justify-between gap-3 sm:flex-row bg-slate-50/50 dark:bg-slate-900/50 rounded-b-2xl backdrop-blur-xl">
                <form method="GET" action="<?php echo e(url()->current()); ?>" class="flex items-center gap-1.5 text-xs text-slate-555 dark:text-slate-400">
                    <?php $__currentLoopData = request()->except('per_page', 'page'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(is_array($value)): ?>
                            <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <input type="hidden" name="<?php echo e($key); ?>[]" value="<?php echo e($v); ?>">
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <span>Show</span>
                    <input type="number" name="per_page" value="<?php echo e($auditLogs->perPage()); ?>" min="1" max="100" 
                           class="w-12 rounded-lg border border-slate-300 dark:border-slate-700 bg-white/70 dark:bg-slate-900/50 py-1 px-1.5 text-center text-xs font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-blue-500 transition-all duration-150"
                           onchange="this.form.submit()">
                    <span>entries</span>
                </form>
                <?php if($auditLogs->hasPages()): ?>
                    <div>
                        <?php echo e($auditLogs->links()); ?>

                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views/audit-logs/index.blade.php ENDPATH**/ ?>