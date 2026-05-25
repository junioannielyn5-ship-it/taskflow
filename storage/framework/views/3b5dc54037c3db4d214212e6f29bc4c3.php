<?php $__env->startSection('content'); ?>
<div class="relative space-y-6">
    <!-- Dynamic Background Effects -->
    <div class="pointer-events-none absolute right-0 top-0 h-[500px] w-[500px] -translate-y-1/3 translate-x-1/3 rounded-full bg-gradient-to-br from-blue-500/20 to-purple-500/20 blur-[80px] dark:from-blue-600/20 dark:to-purple-600/20"></div>
    <div class="pointer-events-none absolute bottom-0 left-0 h-[400px] w-[400px] -translate-x-1/3 translate-y-1/3 rounded-full bg-gradient-to-tr from-emerald-500/20 to-cyan-500/20 blur-[80px] dark:from-emerald-600/20 dark:to-cyan-600/20"></div>

    
    <div class="relative flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between mb-8 z-10">
        <div>
            <div class="mb-2 inline-flex items-center rounded-full border border-blue-200/50 bg-blue-50/50 px-3 py-1 text-xs font-semibold tracking-wide text-blue-700 shadow-sm backdrop-blur-md dark:border-blue-700/50 dark:bg-blue-900/50 dark:text-blue-300">
                <span class="mr-1.5 flex h-2 w-2 rounded-full bg-blue-500"></span>
                Workspace Overview
            </div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                Project <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent dark:from-blue-400 dark:to-indigo-400">Hub</span>
            </h1>
        </div>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-project')): ?>
            <a href="<?php echo e(route('projects.create')); ?>" class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-3 text-sm font-bold text-white shadow-md shadow-blue-500/20 transition-all hover:scale-105 hover:from-blue-500 hover:to-indigo-500 hover:shadow-lg hover:shadow-blue-500/40">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                Create Project
            </a>
        <?php endif; ?>
    </div>

    <div class="relative overflow-visible rounded-2xl border border-white/40 bg-white/40 px-6 py-5 shadow-lg backdrop-blur-xl dark:border-slate-700/50 dark:bg-slate-800/40 flex flex-wrap gap-4 mb-6 z-10">
        <div class="relative inline-block" id="projects-project-picker">
            <button
                type="button"
                id="projects-project-toggle-btn"
                class="inline-flex items-center gap-2 rounded-xl border-0 ring-1 ring-inset ring-slate-300/50 bg-white/70 py-2.5 px-4 text-sm font-medium text-slate-900 shadow-sm backdrop-blur-sm transition-all hover:bg-white focus:ring-2 focus:ring-inset focus:ring-blue-500 dark:bg-slate-900/50 dark:text-white dark:ring-slate-700/50 dark:hover:bg-slate-800"
            >
                <span class="text-xs font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400">Project:</span>
                <span class="font-semibold" id="projects-project-selected-label">All Projects</span>
                <svg class="h-4 w-4 text-slate-400 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
            </button>
            <div id="projects-project-dropdown" class="absolute left-0 z-30 mt-2 hidden min-w-[260px] rounded-xl border border-slate-200/50 dark:border-slate-700/50 bg-white/90 dark:bg-slate-800/90 p-2 shadow-xl backdrop-blur-xl">
                <button type="button" class="projects-project-option-btn block w-full rounded-lg px-3 py-2.5 text-left text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700/50" data-project-name="">All Projects</button>
                <?php $__currentLoopData = ($projects ?? collect())->pluck('name')->filter()->unique()->sort()->values(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projectName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button
                        type="button"
                        class="projects-project-option-btn block w-full rounded-lg px-3 py-2.5 text-left text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700/50"
                        data-project-name="<?php echo e($projectName); ?>"
                    >
                        <?php echo e($projectName); ?>

                    </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <div class="relative inline-block" id="projects-company-picker">
            <button
                type="button"
                id="projects-company-toggle-btn"
                class="inline-flex items-center gap-2 rounded-xl border-0 ring-1 ring-inset ring-slate-300/50 bg-white/70 py-2.5 px-4 text-sm font-medium text-slate-900 shadow-sm backdrop-blur-sm transition-all hover:bg-white focus:ring-2 focus:ring-inset focus:ring-blue-500 dark:bg-slate-900/50 dark:text-white dark:ring-slate-700/50 dark:hover:bg-slate-800"
            >
                <span class="text-xs font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400">Company:</span>
                <span class="font-semibold" id="projects-company-selected-label">All Companies</span>
                <svg class="h-4 w-4 text-slate-400 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
            </button>
            <div id="projects-company-dropdown" class="absolute left-0 z-30 mt-2 hidden min-w-[260px] rounded-xl border border-slate-200/50 dark:border-slate-700/50 bg-white/90 dark:bg-slate-800/90 p-2 shadow-xl backdrop-blur-xl">
                <button type="button" class="projects-company-option-btn block w-full rounded-lg px-3 py-2.5 text-left text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700/50" data-company-name="">All Companies</button>
                <?php $__currentLoopData = ($projects ?? collect())->pluck('company_name')->filter()->unique()->sort()->values(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $companyName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button
                        type="button"
                        class="projects-company-option-btn block w-full rounded-lg px-3 py-2.5 text-left text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700/50"
                        data-company-name="<?php echo e($companyName); ?>"
                    >
                        <?php echo e($companyName); ?>

                    </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 items-stretch">
        <?php $__empty_1 = true; $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="project-card relative overflow-hidden flex flex-col h-full rounded-3xl border border-white/40 bg-white/60 p-6 shadow-lg backdrop-blur-xl dark:border-slate-700/50 dark:bg-slate-800/60 dark:shadow-slate-900/50 hover:shadow-xl hover:-translate-y-1 transition-all duration-300"
                data-project-name="<?php echo e(strtolower((string) $project->name)); ?>"
                data-company-name="<?php echo e(strtolower((string) ($project->company_name ?? ''))); ?>">

                <div class="relative z-10 mb-5">
                    <div class="mb-2 inline-flex items-center gap-1.5 rounded-full bg-slate-100 dark:bg-slate-900/50 px-2.5 py-1">
                        <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                        <h4 class="text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                            <?php echo e($project->company_name ?: '-'); ?>

                        </h4>
                    </div>
                    <h3 class="text-xl font-extrabold text-slate-800 dark:text-white leading-tight">
                        <?php echo e($project->name); ?>

                    </h3>
                </div>

                <div class="relative z-10 grid grid-cols-2 gap-x-4 gap-y-3 text-sm">

                    <div class="col-span-2">
                        <span class="font-semibold text-slate-600 dark:text-slate-300">Project Owner:</span>
                        <span class="font-medium text-slate-800 dark:text-slate-100 ml-1"><?php echo e($project->project_owner ?: '-'); ?></span>
                    </div>

                    <div class="col-span-2">
                        <span class="font-semibold text-slate-600 dark:text-slate-300">Description:</span>
                        <span class="font-medium text-slate-600 dark:text-slate-400 ml-1"><?php echo e(Str::limit($project->description, 80)); ?></span>
                    </div>

                    <div class="col-span-1">
                        <span class="font-semibold text-slate-600 dark:text-slate-300">Status:</span>
                        <?php
                            $statusLabel = ucwords(str_replace('_', ' ', $project->status ?? 'pending_request'));
                            $statusClass = match($project->status) {
                                'ongoing' => 'bg-blue-100 dark:bg-blue-500/20 text-blue-700 dark:text-blue-300 border border-blue-300 dark:border-blue-500/40',
                                'pending_request' => 'bg-orange-100 dark:bg-orange-500/20 text-orange-700 dark:text-orange-300 border border-orange-300 dark:border-orange-500/35',
                                default => 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 border border-slate-300 dark:border-slate-600',
                            };
                        ?>
                        <span class="px-3 py-1 text-xs font-bold rounded-full <?php echo e($statusClass); ?> ml-1">
                            <?php echo e($statusLabel); ?>

                        </span>
                    </div>

                    <div class="col-span-1">
                        <span class="font-semibold text-slate-600 dark:text-slate-300">Your Role:</span>
                        <?php
                            $roleLabel = $project->member_role ?? 'N/A';
                            $roleClass = match($roleLabel) {
                                'admin' => 'bg-purple-100 dark:bg-purple-500/25 text-purple-700 dark:text-purple-300 border border-purple-300 dark:border-purple-500/40',
                                'lead' => 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-500/35',
                                'member' => 'bg-blue-100 dark:bg-blue-500/20 text-blue-700 dark:text-blue-300 border border-blue-300 dark:border-blue-500/35',
                                default => 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 border border-slate-300 dark:border-slate-600',
                            };
                        ?>
                        <span class="px-3 py-1 text-xs font-bold rounded-full <?php echo e($roleClass); ?> ml-1">
                            <?php echo e(ucwords(str_replace('_', ' ', $roleLabel))); ?>

                        </span>
                    </div>
                </div>

                <div class="relative z-10 mt-auto pt-4">
                    <div class="mb-2.5 flex items-center gap-2">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500">Actions</span>
                        <div class="flex-1 h-px bg-slate-200 dark:bg-slate-700"></div>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="<?php echo e(route('projects.show', $project)); ?>" class="inline-flex items-center gap-1.5 rounded-lg border border-blue-200 dark:border-blue-500/30 bg-blue-50/80 dark:bg-blue-500/10 px-3 py-1.5 text-xs font-semibold text-blue-600 dark:text-blue-300 hover:bg-blue-100 dark:hover:bg-blue-500/20 transition-all duration-200 hover:-translate-y-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            View
                        </a>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-task')): ?>
                            <a href="<?php echo e(route('tasks.create', ['project_id' => $project->id])); ?>" class="inline-flex items-center gap-1.5 rounded-lg border border-emerald-200 dark:border-emerald-500/30 bg-emerald-50/80 dark:bg-emerald-500/10 px-3 py-1.5 text-xs font-semibold text-emerald-700 dark:text-emerald-300 hover:bg-emerald-100 dark:hover:bg-emerald-500/20 transition-all duration-200 hover:-translate-y-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                Create Task
                            </a>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $project)): ?>
                            <a href="<?php echo e(route('projects.edit', $project)); ?>" class="inline-flex items-center gap-1.5 rounded-lg border border-amber-200 dark:border-amber-500/30 bg-amber-50/80 dark:bg-amber-500/10 px-3 py-1.5 text-xs font-semibold text-amber-700 dark:text-amber-300 hover:bg-amber-100 dark:hover:bg-amber-500/20 transition-all duration-200 hover:-translate-y-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                Edit
                            </a>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', $project)): ?>
                            <form action="<?php echo e(route('projects.destroy', $project)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this project?')" class="inline-flex items-center gap-1.5 rounded-lg border border-red-200 dark:border-red-500/30 bg-red-50/80 dark:bg-red-500/10 px-3 py-1.5 text-xs font-semibold text-red-600 dark:text-rose-300 hover:bg-red-100 dark:hover:bg-rose-500/20 transition-all duration-200 hover:-translate-y-0.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    Delete
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full flex flex-col items-center justify-center rounded-2xl border border-white/40 bg-white/40 px-6 py-16 text-center shadow-lg backdrop-blur-xl dark:border-slate-700/50 dark:bg-slate-800/40">
                <div class="mb-4 rounded-full bg-slate-100/50 p-4 dark:bg-slate-900/30">
                    <svg class="h-10 w-10 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">No projects found</h3>
                <p class="mt-1 max-w-sm text-sm text-slate-500 dark:text-slate-400">Create a new project to get started.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const projectToggleBtn = document.getElementById('projects-project-toggle-btn');
    const projectDropdown = document.getElementById('projects-project-dropdown');
    const projectSelectedLabel = document.getElementById('projects-project-selected-label');
    const projectOptionButtons = document.querySelectorAll('.projects-project-option-btn');

    const companyToggleBtn = document.getElementById('projects-company-toggle-btn');
    const companyDropdown = document.getElementById('projects-company-dropdown');
    const companySelectedLabel = document.getElementById('projects-company-selected-label');
    const companyOptionButtons = document.querySelectorAll('.projects-company-option-btn');

    const projectCards = document.querySelectorAll('.project-card');

    let selectedProject = '';
    let selectedCompany = '';

    const applyFilters = () => {
        projectCards.forEach((card) => {
            const projectName = String(card.dataset.projectName || '').toLowerCase();
            const companyName = String(card.dataset.companyName || '').toLowerCase();

            const projectMatch = !selectedProject || projectName === selectedProject;
            const companyMatch = !selectedCompany || companyName === selectedCompany;

            card.style.display = (projectMatch && companyMatch) ? '' : 'none';
        });
    };

    const toggleDropdown = (dropdown) => {
        if (!dropdown) return;
        dropdown.classList.toggle('hidden');
    };

    if (projectToggleBtn && projectDropdown) {
        projectToggleBtn.addEventListener('click', () => {
            if (companyDropdown) {
                companyDropdown.classList.add('hidden');
            }
            toggleDropdown(projectDropdown);
        });
    }

    if (companyToggleBtn && companyDropdown) {
        companyToggleBtn.addEventListener('click', () => {
            if (projectDropdown) {
                projectDropdown.classList.add('hidden');
            }
            toggleDropdown(companyDropdown);
        });
    }

    projectOptionButtons.forEach((button) => {
        button.addEventListener('click', () => {
            selectedProject = String(button.dataset.projectName || '').toLowerCase();
            if (projectSelectedLabel) {
                projectSelectedLabel.textContent = button.dataset.projectName || 'All Projects';
            }
            if (projectDropdown) {
                projectDropdown.classList.add('hidden');
            }
            applyFilters();
        });
    });

    companyOptionButtons.forEach((button) => {
        button.addEventListener('click', () => {
            selectedCompany = String(button.dataset.companyName || '').toLowerCase();
            if (companySelectedLabel) {
                companySelectedLabel.textContent = button.dataset.companyName || 'All Companies';
            }
            if (companyDropdown) {
                companyDropdown.classList.add('hidden');
            }
            applyFilters();
        });
    });

    document.addEventListener('click', (event) => {
        const target = event.target;
        if (
            projectDropdown && projectToggleBtn
            && !projectDropdown.contains(target) && !projectToggleBtn.contains(target)
        ) {
            projectDropdown.classList.add('hidden');
        }

        if (
            companyDropdown && companyToggleBtn
            && !companyDropdown.contains(target) && !companyToggleBtn.contains(target)
        ) {
            companyDropdown.classList.add('hidden');
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views/projects/index.blade.php ENDPATH**/ ?>