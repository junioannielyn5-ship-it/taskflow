<?php

use App\Modules\Tasks\Http\Controllers\TaskController;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', SubstituteBindings::class])->group(function () {
    // Tasks resource nested under projects
    Route::get('/projects/{project}/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/projects/{project}/tasks', [TaskController::class, 'store'])->name('tasks.store');

    // Task operations
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->whereNumber('task')->name('tasks.show');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->whereNumber('task')->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->whereNumber('task')->name('tasks.destroy');

    // Assignment operations
    Route::post('/tasks/{task}/assign', [TaskController::class, 'assign'])->whereNumber('task')->name('tasks.assign');
    Route::delete('/tasks/{task}/assignees/{userId}', [TaskController::class, 'unassign'])->whereNumber('task')->name('tasks.unassign');

    // Task activity log
    Route::get('/tasks/{task}/activity', [\App\Modules\Tasks\Http\Controllers\TaskActivityController::class, 'index'])->whereNumber('task')->name('tasks.activity');
});
