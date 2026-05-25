<?php $__env->startSection('content'); ?>
<div class="space-y-6 bg-slate-100 dark:bg-slate-900 min-h-screen p-6">



    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-bold text-slate-800 dark:text-slate-100">Projects</h2>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-project')): ?>
            <a href="<?php echo e(route('projects.create')); ?>" class="rounded-xl bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 px-4 py-2 text-white font-semibold shadow-md dark:shadow-none transition hover:-translate-y-0.5">Create Project</a>
        <?php endif; ?>
    </div>

    <div class="relative overflow-visible rounded-2xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 p-4 shadow-md dark:shadow-none flex flex-wrap gap-4 mb-4">
        <div class="relative inline-block" id="projects-project-picker">
            <button
                type="button"
                id="projects-project-toggle-btn"
                class="inline-flex items-center gap-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 px-3 py-2 text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-600"
            >
                Project
                <span class="text-xs text-slate-500 dark:text-slate-400" id="projects-project-selected-label">All Projects</span>
            </button>
            <div id="projects-project-dropdown" class="absolute left-0 z-20 mt-2 hidden min-w-[260px] rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 p-2 shadow-xl">
                <button type="button" class="projects-project-option-btn block w-full rounded-lg px-3 py-2 text-left text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700" data-project-name="">All Projects</button>
                <?php $__currentLoopData = ($projects ?? collect())->pluck('name')->filter()->unique()->sort()->values(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projectName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button
                        type="button"
                        class="projects-project-option-btn block w-full rounded-lg px-3 py-2 text-left text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700"
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
                class="inline-flex items-center gap-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 px-3 py-2 text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-600"
            >
                Company Name
                <span class="text-xs text-slate-500 dark:text-slate-400" id="projects-company-selected-label">All Companies</span>
            </button>
            <div id="projects-company-dropdown" class="absolute left-0 z-20 mt-2 hidden min-w-[260px] rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 p-2 shadow-xl">
                <button type="button" class="projects-company-option-btn block w-full rounded-lg px-3 py-2 text-left text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700" data-company-name="">All Companies</button>
                <?php $__currentLoopData = ($projects ?? collect())->pluck('company_name')->filter()->unique()->sort()->values(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $companyName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button
                        type="button"
                        class="projects-company-option-btn block w-full rounded-lg px-3 py-2 text-left text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700"
                        data-company-name="<?php echo e($companyName); ?>"
                    >
                        <?php echo e($companyName); ?>

                    </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-stretch">
        <?php $__empty_1 = true; $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="project-card relative overflow-hidden flex flex-col h-full rounded-3xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 p-6 shadow-md dark:shadow-none hover:shadow-lg transition-all duration-300"
                data-project-name="<?php echo e(strtolower((string) $project->name)); ?>"
                data-company-name="<?php echo e(strtolower((string) ($project->company_name ?? ''))); ?>">

                <div class="relative z-10 mb-4">
                    <h4 class="text-xs uppercase font-semibold text-slate-500 dark:text-slate-400 tracking-wider">
                        <?php echo e($project->company_name ?: '-'); ?>

                    </h4>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 mt-1">
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
            <div class="col-span-full rounded-2xl border border-dashed border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-6 py-12 text-center">
                <p class="text-sm text-slate-500 dark:text-slate-400">No projects found.</p>
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views\projects\index.blade.php ENDPATH**/ ?>