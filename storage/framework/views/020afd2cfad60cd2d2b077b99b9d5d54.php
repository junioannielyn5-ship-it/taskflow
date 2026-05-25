<?php $__env->startSection('content'); ?>
<div class="space-y-4">
    <div class="relative overflow-hidden rounded-xl border border-slate-200/40 bg-white/90 p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900/90">
        <div class="pointer-events-none absolute -right-16 -top-16 h-52 w-52 rounded-full bg-blue-200/25 dark:bg-blue-950/20 blur-3xl"></div>
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white"><?php echo e($task->title); ?></h1>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Project: <span class="font-semibold text-slate-700 dark:text-slate-300"><?php echo e($task->project?->name ?? 'N/A'); ?></span></p>
            </div>
            <a href="<?php echo e(route('tasks.list')); ?>" class="inline-flex items-center justify-center rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 px-3 py-1.5 text-xs font-semibold text-slate-700 dark:text-slate-300 shadow-sm hover:bg-slate-50 dark:hover:bg-slate-800 transition-all duration-200 hover:-translate-y-0.5">Back to Tasks</a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="mb-4 rounded border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/30 px-4 py-3 text-green-700 dark:text-green-400">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('info')): ?>
        <div class="mb-4 rounded border border-blue-200 dark:border-blue-800 bg-blue-50 dark:bg-blue-900/30 px-4 py-3 text-blue-700 dark:text-blue-400">
            <?php echo e(session('info')); ?>

        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
        <div class="space-y-4 lg:col-span-2">
            <div class="rounded-xl border border-slate-200/40 bg-white/90 p-4 dark:border-slate-800 dark:bg-slate-900/90 shadow-sm">
                <h2 class="mb-3 text-sm font-bold text-slate-800 dark:text-slate-100">Task Details</h2>
                <div class="grid grid-cols-1 gap-x-4 gap-y-3 md:grid-cols-2">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-wide text-slate-450 dark:text-slate-500">Status</p>
                        <p class="text-xs font-semibold text-slate-800 dark:text-slate-200 mt-0.5"><?php echo e(ucwords(str_replace('_', ' ', $task->status))); ?></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-wide text-slate-450 dark:text-slate-500">Priority</p>
                        <p class="text-xs font-semibold text-slate-800 dark:text-slate-200 mt-0.5"><?php echo e(ucfirst($task->priority)); ?></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-wide text-slate-450 dark:text-slate-500">Due</p>
                        <p class="text-xs font-semibold text-slate-800 dark:text-slate-200 mt-0.5"><?php echo e($task->due_date ? $task->due_date->format('m-d-Y') : '-'); ?></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-wide text-slate-450 dark:text-slate-500">Date Received</p>
                        <p class="text-xs font-semibold text-slate-800 dark:text-slate-200 mt-0.5"><?php echo e($task->date_received ? $task->date_received->format('M d, Y') : '-'); ?></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-wide text-slate-450 dark:text-slate-500">Date Started</p>
                        <p class="text-xs font-semibold text-slate-800 dark:text-slate-200 mt-0.5"><?php echo e($task->date_started ? $task->date_started->format('M d, Y') : '-'); ?></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-wide text-slate-450 dark:text-slate-500">Task Process</p>
                        <p class="text-xs font-semibold text-slate-800 dark:text-slate-200 mt-0.5"><?php echo e($task->task_process ?: '-'); ?></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-wide text-slate-450 dark:text-slate-500">Company/Client</p>
                        <p class="text-xs font-semibold text-slate-800 dark:text-slate-200 mt-0.5"><?php echo e($task->company ?: '-'); ?></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-wide text-slate-450 dark:text-slate-500">Person-in-charge</p>
                        <p class="text-xs font-semibold text-slate-800 dark:text-slate-200 mt-0.5"><?php echo e($task->team_in_charge ?: '-'); ?></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-wide text-slate-450 dark:text-slate-500">Blocked By</p>
                        <p class="text-xs font-semibold text-slate-800 dark:text-slate-200 mt-0.5">
                            <?php if($task->blockedByTask): ?>
                                <a href="<?php echo e(route('tasks.show', $task->blockedByTask)); ?>" class="text-blue-650 dark:text-blue-400 hover:underline"><?php echo e($task->blockedByTask->title); ?></a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-wide text-slate-450 dark:text-slate-500">Deliverables</p>
                        <p class="text-xs font-semibold text-slate-800 dark:text-slate-200 mt-0.5"><?php echo e($task->deliverables ?: '-'); ?></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-wide text-slate-450 dark:text-slate-500">Project Owner</p>
                        <p class="text-xs font-semibold text-slate-800 dark:text-slate-200 mt-0.5"><?php echo e($task->project?->project_owner ?: 'Sales (Sales Project)'); ?></p>
                    </div>
                </div>
                <?php if($task->remarks): ?>
                    <div class="mt-3 rounded-lg border border-amber-200/50 dark:border-amber-800/40 bg-amber-50/50 dark:bg-amber-900/20 p-3 text-xs text-amber-900 dark:text-amber-200">
                        <p class="mb-1 text-[10px] font-bold uppercase tracking-wide">Remarks</p>
                        <p><?php echo e($task->remarks); ?></p>
                    </div>
                <?php endif; ?>
                <?php if($task->description): ?>
                    <div class="mt-3 rounded-lg border border-slate-200/40 bg-slate-50/50 dark:border-slate-800 dark:bg-slate-900/50 p-3 text-xs text-slate-750 dark:text-slate-350">
                        <?php echo e($task->description); ?>

                    </div>
                <?php endif; ?>
            </div>

            <div class="rounded-xl border border-slate-200/40 bg-white/90 p-4 dark:border-slate-800 dark:bg-slate-900/90 shadow-sm">
                <h2 class="mb-3 text-sm font-bold text-slate-800 dark:text-slate-100">Checklists</h2>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $task)): ?>
                    <form method="POST" action="<?php echo e(route('tasks.checklists.store', $task)); ?>" class="mb-3 flex flex-col gap-2 sm:flex-row">
                        <?php echo csrf_field(); ?>
                        <input
                            type="text"
                            name="title"
                            required
                            placeholder="Add checklist item"
                            class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 px-2.5 py-1.5 text-xs text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-1 focus:ring-blue-500 outline-none transition-all"
                        >
                        <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-3 py-1.5 text-[11px] font-semibold text-white shadow-sm hover:bg-blue-700 transition-all duration-200 hover:-translate-y-0.5">Add</button>
                    </form>
                    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mb-3 text-xs text-red-650 font-semibold"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <?php endif; ?>

                <?php if($task->checklistItems->isEmpty()): ?>
                    <p class="text-xs text-slate-500 dark:text-slate-400">No checklist items yet.</p>
                <?php else: ?>
                    <ul class="space-y-1.5">
                        <?php $__currentLoopData = $task->checklistItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="flex items-center justify-between gap-2 rounded-lg border border-slate-200/40 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/50 px-2.5 py-1.5 text-xs">
                                <form method="POST" action="<?php echo e(route('tasks.checklists.toggle', [$task, $item])); ?>" class="flex items-center gap-2">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>
                                    <button type="submit" class="h-3.5 w-3.5 rounded border border-slate-300 dark:border-slate-700 <?php echo e($item->is_completed ? 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600' : 'bg-white dark:bg-slate-900'); ?>"></button>
                                    <span class="<?php echo e($item->is_completed ? 'text-slate-400 line-through' : 'text-slate-700 dark:text-slate-300'); ?>"><?php echo e($item->title); ?></span>
                                </form>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $task)): ?>
                                    <form method="POST" action="<?php echo e(route('tasks.checklists.destroy', [$task, $item])); ?>" onsubmit="return confirm('Delete this checklist item?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="inline-flex items-center gap-1 rounded border border-red-100 dark:border-red-900/50 bg-red-50/50 dark:bg-red-950/40 px-2 py-0.5 text-[10px] font-semibold text-red-650 dark:text-red-400 hover:bg-red-100/80 dark:hover:bg-red-900/50 transition-all duration-200 hover:-translate-y-0.5 shadow-sm">Delete</button>
                                    </form>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php endif; ?>
            </div>

            <div class="rounded-xl border border-slate-200/40 bg-white/90 p-4 dark:border-slate-800 dark:bg-slate-900/90 shadow-sm">
                <h2 class="mb-3 text-sm font-bold text-slate-800 dark:text-slate-100">Task Attachments</h2>
                <form method="POST" action="<?php echo e(route('tasks.attachments.store', $task)); ?>" enctype="multipart/form-data" class="mb-3 flex flex-col gap-3 md:flex-row md:items-center">
                    <?php echo csrf_field(); ?>
                    <input type="file" name="file" required class="block w-full text-xs text-slate-700 dark:text-slate-350 file:mr-3 file:rounded-lg file:border-0 file:bg-blue-600 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white hover:file:bg-blue-700 cursor-pointer">
                    <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-3 py-1.5 text-[11px] font-semibold text-white shadow-sm hover:bg-blue-700 transition-all duration-200 hover:-translate-y-0.5">Upload</button>
                </form>

                <?php $__errorArgs = ['file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mb-3 text-xs text-red-600 font-semibold"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <?php if($task->attachments->isEmpty()): ?>
                    <p class="text-xs text-slate-500 dark:text-slate-400">No attachments yet.</p>
                <?php else: ?>
                    <ul class="divide-y divide-slate-100/50 dark:divide-slate-800/55">
                        <?php $__currentLoopData = $task->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="flex items-center justify-between py-2 text-xs">
                                <div>
                                    <p class="font-semibold text-slate-750 dark:text-slate-300"><?php echo e($attachment->filename); ?></p>
                                    <p class="text-[10px] text-slate-500 dark:text-slate-450"><?php echo e(number_format($attachment->size / 1024, 1)); ?> KB · <?php echo e($attachment->created_at?->diffForHumans()); ?></p>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <?php if(str_starts_with($attachment->mime_type, 'image/')): ?>
                                        <button type="button" onclick="openImageModal('<?php echo e(route('attachments.view', $attachment->id)); ?>')" class="inline-flex items-center gap-1.5 rounded border border-blue-100 dark:border-blue-900/50 bg-blue-50/50 dark:bg-blue-950/40 px-2.5 py-0.5 text-[10px] font-semibold text-blue-600 dark:text-blue-400 hover:bg-blue-100/80 dark:hover:bg-blue-900/50 transition-all duration-200 hover:-translate-y-0.5 shadow-sm">View</button>
                                    <?php endif; ?>
                                    <a href="<?php echo e(route('attachments.download', $attachment->id)); ?>" class="inline-flex items-center gap-1.5 rounded border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/50 px-2.5 py-0.5 text-[10px] font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all duration-200 hover:-translate-y-0.5 shadow-sm">Download</a>
                                    <?php if(auth()->id() === $attachment->user_id || auth()->user()?->isAdmin()): ?>
                                        <form method="POST" action="<?php echo e(route('attachments.destroy', $attachment->id)); ?>" onsubmit="return confirm('Delete this attachment?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="inline-flex items-center gap-1.5 rounded border border-red-100 dark:border-red-900/50 bg-red-50/50 dark:bg-red-950/40 px-2.5 py-0.5 text-[10px] font-semibold text-red-650 dark:text-red-400 hover:bg-red-100/80 dark:hover:bg-red-900/50 transition-all duration-200 hover:-translate-y-0.5 shadow-sm">Delete</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php endif; ?>
            </div>>
            <div class="rounded-xl border border-slate-200/40 bg-white/90 p-4 dark:border-slate-800 dark:bg-slate-900/90 shadow-sm">
                <div class="mb-3 flex items-center justify-between gap-3">
                    <h2 class="text-sm font-bold text-slate-800 dark:text-slate-100">Activity Timeline</h2>
                    <span id="task-activity-count" class="rounded-full bg-slate-100 dark:bg-slate-850 border border-slate-200/50 dark:border-slate-800 px-2 py-0.5 text-[10px] font-bold text-slate-650 dark:text-slate-300 shadow-sm">0</span>
                </div>
                <div id="task-activity-timeline" class="space-y-3">
                    <p class="text-xs text-slate-500 dark:text-slate-400">Loading timeline...</p>
                </div>
            </div>

            <div class="rounded-xl border border-slate-200/40 bg-white/90 p-4 dark:border-slate-800 dark:bg-slate-900/90 shadow-sm">
                <h2 class="mb-3 text-sm font-bold text-slate-800 dark:text-slate-100">Comments</h2>

                <form method="POST" action="<?php echo e(route('comments.store', $task)); ?>" class="mb-3 space-y-2">
                    <?php echo csrf_field(); ?>
                    <textarea
                        name="body"
                        rows="3"
                        required
                        class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 px-2.5 py-1.5 text-xs text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-1 focus:ring-blue-500 outline-none transition-all"
                        placeholder="Write a comment..."
                    ><?php echo e(old('body')); ?></textarea>
                    <div class="flex items-center justify-between">
                        <?php $__errorArgs = ['body'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-xs text-red-600 font-semibold"><?php echo e($message); ?></p>
                        <?php else: ?>
                            <span class="text-[10px] text-slate-550 dark:text-slate-450">Share updates, blockers, or clarifications.</span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-3 py-1.5 text-[11px] font-semibold text-white shadow-sm hover:bg-blue-700 transition-all duration-200 hover:-translate-y-0.5">Post Comment</button>
                    </div>
                </form>

                <?php if($task->comments->isEmpty()): ?>
                    <p class="text-xs text-slate-500 dark:text-slate-400">No comments yet.</p>
                <?php else: ?>
                    <ul class="space-y-2">
                        <?php $__currentLoopData = $task->comments->sortByDesc('created_at')->take(20); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="rounded-lg border border-slate-200/40 bg-slate-50 dark:bg-slate-900/50 p-2.5 text-xs">
                                <div class="mb-1 flex items-center justify-between text-[10px] text-slate-500 dark:text-slate-450">
                                    <span class="font-bold text-slate-800 dark:text-slate-200"><?php echo e($comment->user?->name ?? 'Unknown user'); ?></span>
                                    <div class="flex items-center gap-2">
                                        <span><?php echo e($comment->created_at?->diffForHumans()); ?></span>
                                        <?php if(auth()->id() === $comment->user_id || auth()->user()?->isAdmin()): ?>
                                            <form method="POST" action="<?php echo e(route('comments.destroy', $comment->id)); ?>" onsubmit="return confirm('Delete this comment?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="rounded border border-red-100 dark:border-red-900/50 bg-red-50/50 dark:bg-red-950/40 px-1.5 py-0.5 text-[9px] font-semibold text-red-650 dark:text-red-400 hover:bg-red-100/80 dark:hover:bg-red-900/50 transition-all duration-200 hover:-translate-y-0.5 shadow-sm">Delete</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <p class="text-slate-700 dark:text-slate-350 mt-0.5 leading-normal"><?php echo e($comment->body); ?></p>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php endif; ?>
            </div>>
        </div>
        <div class="space-y-4">
            <div class="rounded-xl border border-slate-200/40 bg-white/90 p-4 dark:border-slate-800 dark:bg-slate-900/90 shadow-sm">
                <h2 class="mb-2 text-sm font-bold text-slate-800 dark:text-slate-100">Completion</h2>
                <p class="mb-3 text-xs text-slate-550 dark:text-slate-400 leading-normal">Submit for review when work is finished, then manager/admin can approve as done.</p>

                <?php
                    $hasCompletionDocument = $task->attachments->isNotEmpty();
                    $hasIncompleteChecklists = $task->checklistItems->where('is_completed', false)->count() > 0;
                    $canUpdateTaskStatus = auth()->user() && Gate::allows('update-task-status', $task);
                    $canCompleteTask = auth()->user() && Gate::allows('complete-task', $task);
                    $canApproveNow = $task->status === 'for_review' && $canCompleteTask;
                    $approvalStatusLabel = match($task->status) {
                        'done' => 'Approved',
                        'for_review' => 'Pending Review',
                        default => 'Not Submitted',
                    };
                    $approvalStatusClass = match($task->status) {
                        'done' => 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-750 dark:text-emerald-350 border border-emerald-200/60 dark:border-emerald-800 px-2 py-0.5 text-[10px] font-bold rounded-md',
                        'for_review' => 'bg-orange-100 dark:bg-orange-500/20 text-orange-750 dark:text-orange-350 border border-orange-200/60 dark:border-orange-800 px-2 py-0.5 text-[10px] font-bold rounded-md',
                        default => 'bg-slate-100 dark:bg-slate-700/50 text-slate-650 dark:text-slate-350 border border-slate-200 dark:border-slate-800 px-2 py-0.5 text-[10px] font-bold rounded-md',
                    };
                ?>

                <div class="mb-3 rounded-lg border <?php echo e(($hasCompletionDocument && !$hasIncompleteChecklists) ? 'border-emerald-200/40 dark:border-emerald-800/40 bg-emerald-50/50 dark:bg-emerald-950/20' : 'border-amber-200/40 dark:border-amber-800/40 bg-amber-50/50 dark:bg-amber-950/20'); ?> px-3 py-2 text-xs">
                    <div class="mb-1 flex items-start justify-between gap-3">
                        <div class="min-w-0 flex-1">
                            <p class="font-bold <?php echo e(($hasCompletionDocument && !$hasIncompleteChecklists) ? 'text-emerald-700 dark:text-emerald-400' : 'text-amber-700 dark:text-amber-400'); ?>">
                                <?php echo e(($hasCompletionDocument && !$hasIncompleteChecklists) ? 'Ready for review' : 'Requirements pending'); ?>

                            </p>
                            <div class="mt-1 space-y-0.5 text-[11px] font-medium <?php echo e(($hasCompletionDocument && !$hasIncompleteChecklists) ? 'text-emerald-600 dark:text-emerald-500' : 'text-amber-600 dark:text-amber-500'); ?>">
                                <?php if(!$hasCompletionDocument): ?>
                                    <p>• Upload at least one proof file.</p>
                                <?php endif; ?>
                                <?php if($hasIncompleteChecklists): ?>
                                    <p>• Complete all checklist items.</p>
                                <?php endif; ?>
                                <?php if($hasCompletionDocument && !$hasIncompleteChecklists): ?>
                                    <p>All requirements met. You can request a review.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <span class="inline-flex shrink-0 items-center <?php echo e($approvalStatusClass); ?>">
                            <?php echo e($approvalStatusLabel); ?>

                        </span>
                    </div>
                </div>

                <?php if($canUpdateTaskStatus): ?>
                    <div class="grid grid-cols-1 gap-2">
                        <?php if(!in_array($task->status, ['in_progress', 'for_review', 'done'])): ?>
                            <form method="POST" action="<?php echo e(route('tasks.status.update', $task)); ?>" onsubmit="const btn = this.querySelector('button'); setTimeout(() => { btn.disabled = true; btn.textContent = 'Updating...'; }, 0);">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="status" value="in_progress">
                                <button type="submit" class="w-full inline-flex items-center justify-center rounded-lg bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-blue-700 transition-all duration-200 hover:-translate-y-0.5">
                                    Start Progress
                                </button>
                            </form>
                        <?php elseif($task->status === 'in_progress'): ?>
                            <?php if(!$hasCompletionDocument || $hasIncompleteChecklists): ?>
                                <button type="button" class="w-full inline-flex items-center justify-center rounded-lg bg-slate-200 dark:bg-slate-700 px-3 py-1.5 text-xs font-semibold text-slate-550 dark:text-slate-400 cursor-not-allowed" disabled>
                                    Mark As For Review
                                </button>
                            <?php else: ?>
                                <form method="POST" action="<?php echo e(route('tasks.status.update', $task)); ?>" onsubmit="const btn = this.querySelector('button'); setTimeout(() => { btn.disabled = true; btn.textContent = 'Updating...'; }, 0);">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="status" value="for_review">
                                    <button type="submit" class="w-full inline-flex items-center justify-center rounded-lg bg-orange-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-orange-700 transition-all duration-200 hover:-translate-y-0.5">
                                        Mark As For Review
                                    </button>
                                </form>
                            <?php endif; ?>
                        <?php elseif($task->status === 'for_review'): ?>
                            <?php if($canApproveNow): ?>
                                <form method="POST" action="<?php echo e(route('tasks.status.update', $task)); ?>" onsubmit="const btn = this.querySelector('button'); setTimeout(() => { btn.disabled = true; btn.textContent = 'Updating...'; }, 0);">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="status" value="done">
                                    <button type="submit" class="w-full inline-flex items-center justify-center rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-emerald-700 transition-all duration-200 hover:-translate-y-0.5">
                                        Approve As Done
                                    </button>
                                </form>
                            <?php else: ?>
                                <button type="button" class="w-full inline-flex items-center justify-center rounded-lg px-3 py-1.5 text-xs font-semibold text-white bg-slate-200 dark:bg-slate-700 cursor-not-allowed" disabled>
                                    Pending Review
                                </button>
                            <?php endif; ?>
                        <?php elseif($task->status === 'done'): ?>
                            <button type="button" class="w-full inline-flex items-center justify-center rounded-lg px-3 py-1.5 text-xs font-semibold text-white bg-emerald-600 cursor-not-allowed" disabled>
                                Approved As Done
                            </button>
                        <?php endif; ?>
                    </div>
                    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-2 text-xs text-red-600 font-semibold"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <?php else: ?>
                    <p class="text-xs text-slate-500 dark:text-slate-400">You are not allowed to change task status.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php
    $taskTimelineData = [
        'timelineUrl' => route('tasks.activities', $task),
        'statusUpdateUrl' => route('tasks.status.update', $task),
        'transitionsUrl' => route('tasks.transitions', $task),
        'csrfToken' => csrf_token(),
        'hasCompletionDocument' => $hasCompletionDocument,
        'currentStatus' => $task->status,
    ];
?>
<script id="task-timeline-data" type="application/json"><?php echo json_encode($taskTimelineData, 15, 512) ?></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const payloadEl = document.getElementById('task-timeline-data');
    const payload = payloadEl ? JSON.parse(payloadEl.textContent || '{}') : {};
    const timelineEl = document.getElementById('task-activity-timeline');
    const countEl = document.getElementById('task-activity-count');
    const statusButtons = document.querySelectorAll('[data-task-status]');
    const statusFeedbackEl = document.getElementById('task-status-feedback');
    let currentStatus = String(payload.currentStatus || '');

    statusButtons.forEach((button) => {
        button.dataset.initiallyDisabled = button.disabled ? '1' : '0';
    });

    const escapeHtml = (value) => String(value ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');

    const iconSvg = (actionType) => {
        if (actionType === 'status_change') {
            return '<svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>';
        }

        if (actionType === 'assignee_change') {
            return '<svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1118.879 17.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>';
        }

        if (actionType === 'comment_added' || actionType === 'comment_created') {
            return '<svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h8M8 14h5m-9 7l2.6-2.6A2 2 0 004 17V5a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H8.6a2 2 0 00-1.4.6L4 21z" /></svg>';
        }

        return '<svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l2 2m6-2a8 8 0 11-16 0 8 8 0 0116 0z" /></svg>';
    };

    const renderTimeline = (activities) => {
        if (!timelineEl) {
            return;
        }

        if (!activities || activities.length === 0) {
            timelineEl.innerHTML = '<p class="text-xs text-slate-500 dark:text-slate-400">No activity recorded yet.</p>';
            if (countEl) {
                countEl.textContent = '0';
            }
            return;
        }

        if (countEl) {
            countEl.textContent = String(activities.length);
        }

        timelineEl.innerHTML = `<ol class="relative border-l border-slate-200 dark:border-slate-700 pl-5 space-y-5">${activities.map((item) => {
            const actor = escapeHtml(item.actor_name || item.actor?.name || 'Unknown User');
            const description = escapeHtml(item.action_text || item.description || '-');
            const ts = escapeHtml(item.created_at_human || item.timestamp_human || 'just now');
            const isAutomation = Boolean(item.is_automation || item.is_system);
            const bgClass = isAutomation ? 'bg-violet-100 text-violet-700 border-violet-200' : 'bg-blue-100 text-blue-700 dark:text-blue-400 border-blue-200 dark:border-blue-800';
            const badge = isAutomation ? '<span class="ml-2 rounded-full bg-violet-100 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-violet-700">Bot</span>' : '';

            return `
                <li class="relative">
                    <span class="absolute -left-[27px] mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full border ${bgClass}">
                        ${iconSvg(item.action_type)}
                    </span>
                    <div class="rounded-lg border border-slate-200/40 bg-white/95 dark:bg-slate-900/90 p-2.5 shadow-sm">
                        <div class="flex items-center justify-between gap-2">
                            <p class="flex items-center text-xs font-bold text-slate-850 dark:text-white">${actor}${badge}</p>
                            <span class="text-[10px] text-slate-400/80">${ts}</span>
                        </div>
                        <p class="mt-0.5 text-xs text-slate-600 dark:text-slate-400 leading-normal">${description}</p>
                    </div>
                </li>
            `;
        }).join('')}</ol>`;
    };

    const loadTimeline = async () => {
        if (!payload.timelineUrl) {
            return;
        }

        try {
            const response = await fetch(payload.timelineUrl, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                timelineEl.innerHTML = '<p class="text-sm text-red-500">Failed to load timeline.</p>';
                return;
            }

            const data = await response.json();
            renderTimeline(data.activities || []);
        } catch (error) {
            timelineEl.innerHTML = '<p class="text-sm text-red-500">Failed to load timeline.</p>';
        }
    };

    const setStatusFeedback = (message, isError = false) => {
        if (!statusFeedbackEl) {
            return;
        }

        statusFeedbackEl.textContent = message;
        statusFeedbackEl.className = `mt-2 text-sm ${isError ? 'text-red-600' : 'text-emerald-700 dark:text-emerald-400'}`;
    };

    const applyStatusActionAvailability = async () => {
        if (!payload.transitionsUrl || statusButtons.length === 0) {
            return;
        }

        statusButtons.forEach((button) => {
            button.disabled = true;
            button.dataset.initiallyDisabled = '1';
        });

        try {
            const response = await fetch(payload.transitionsUrl, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin',
            });

            const data = await response.json().catch(() => ({}));

            if (!response.ok) {
                setStatusFeedback(data.message || 'Unable to load allowed status transitions.', true);
                return;
            }

            const validTransitions = Array.isArray(data.valid_transitions) ? data.valid_transitions.map(String) : [];
            const canComplete = Boolean(data.can_complete);
            currentStatus = String(data.current_status || currentStatus);

            statusButtons.forEach((button) => {
                const status = String(button.getAttribute('data-task-status') || '');
                const needsDocument = button.getAttribute('data-needs-document') === '1';

                // Keep core actions clickable and perform safe transitions in click handler.
                let allowed = status === 'in_progress' || status === 'done' || validTransitions.includes(status);

                if (status === 'done' && !canComplete) {
                    allowed = false;
                }

                if (needsDocument && !payload.hasCompletionDocument) {
                    allowed = false;
                }

                button.disabled = !allowed;
                button.dataset.initiallyDisabled = allowed ? '0' : '1';
            });

            const fromStatus = String(data.current_status || payload.currentStatus || '').replace('_', ' ');
            const validText = validTransitions.length > 0 ? validTransitions.map((s) => s.replace('_', ' ')).join(', ') : 'none';
            setStatusFeedback(`Current status: ${fromStatus}. Allowed next: ${validText}.`, false);
        } catch (error) {
            setStatusFeedback('Unable to load allowed status transitions.', true);
        }
    };

    const withButtonsDisabled = (disabled) => {
        statusButtons.forEach((button) => {
            const wasInitiallyDisabled = button.dataset.initiallyDisabled === '1';
            button.disabled = disabled || wasInitiallyDisabled;
        });
    };

    const postStatusUpdate = async (status) => {
        const response = await fetch(payload.statusUpdateUrl, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': payload.csrfToken || '',
            },
            credentials: 'same-origin',
            body: JSON.stringify({ status }),
        });

        const result = await response.json().catch(() => ({}));

        if (!response.ok) {
            throw new Error(result.message || 'Failed to update task status.');
        }

        currentStatus = String(result.task?.status || status);
        return result;
    };

    statusButtons.forEach((button) => {
        button.addEventListener('click', async () => {
            const status = button.getAttribute('data-task-status');
            if (!status || !payload.statusUpdateUrl) {
                return;
            }

            setStatusFeedback('Updating task status...', false);
            withButtonsDisabled(true);

            try {
                if (status === 'in_progress') {
                    if (currentStatus === 'in_progress') {
                        setStatusFeedback('Task is already in progress.', false);
                        return;
                    }

                    const result = await postStatusUpdate('in_progress');
                    setStatusFeedback(result.message || 'Task status updated successfully.', false);
                    window.setTimeout(() => window.location.reload(), 600);
                    return;
                }

                if (status === 'done') {
                    if (currentStatus === 'done') {
                        setStatusFeedback('Task is already done.', false);
                        return;
                    }

                    const sequenceMap = {
                        todo: ['in_progress', 'for_review', 'done'],
                        blocked: ['in_progress', 'for_review', 'done'],
                        in_progress: ['for_review', 'done'],
                        for_review: ['done'],
                    };

                    const sequence = sequenceMap[currentStatus] || ['done'];

                    for (const nextStatus of sequence) {
                        await postStatusUpdate(nextStatus);
                    }

                    setStatusFeedback('Task approved as done.', false);
                    window.setTimeout(() => window.location.reload(), 600);
                    return;
                }

                const result = await postStatusUpdate(status);

                setStatusFeedback(result.message || 'Task status updated successfully.', false);
                window.setTimeout(() => window.location.reload(), 600);
            } catch (error) {
                const message = error instanceof Error ? error.message : 'Failed to update task status.';
                setStatusFeedback(message, true);
            } finally {
                withButtonsDisabled(false);
            }
        });
    });

    loadTimeline();
    applyStatusActionAvailability();
});

function openImageModal(url) {
    const modal = document.getElementById('image-view-modal');
    const img = document.getElementById('modal-image-element');
    img.src = url;
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('image-view-modal');
    const img = document.getElementById('modal-image-element');
    img.src = '';
    modal.classList.add('hidden');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modal = document.getElementById('image-view-modal');
        if (modal && !modal.classList.contains('hidden')) {
            closeImageModal();
        }
    }
});
</script>

<!-- Image View Modal -->
<div id="image-view-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-slate-900/80 p-4 backdrop-blur-sm" onclick="closeImageModal()">
    <div class="relative max-h-full max-w-5xl w-full flex flex-col justify-center items-center" onclick="event.stopPropagation()">
        <button type="button" onclick="closeImageModal()" class="absolute -top-12 right-0 rounded-full bg-white/20 p-2 text-white hover:bg-white/40 focus:outline-none transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <div class="overflow-auto max-h-[85vh] rounded-lg shadow-2xl bg-slate-800/50">
            <img id="modal-image-element" src="" class="max-w-full object-contain" alt="Attachment Image">
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views/tasks/show.blade.php ENDPATH**/ ?>