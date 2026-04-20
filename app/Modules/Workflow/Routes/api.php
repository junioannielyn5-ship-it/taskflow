<?php

use App\Modules\Workflow\Http\Controllers\ActivityController;
use App\Modules\Workflow\Http\Controllers\TaskStatusController;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', SubstituteBindings::class])->group(function () {
    // Status management
    Route::post('/tasks/{task}/status', [TaskStatusController::class, 'update'])->whereNumber('task')->name('tasks.status.update');
    Route::get('/tasks/{task}/transitions', [TaskStatusController::class, 'getTransitions'])->whereNumber('task')->name('tasks.transitions');

    // Activity history
    Route::get('/tasks/{task}/activity', [ActivityController::class, 'timeline'])->whereNumber('task')->name('tasks.activity.timeline');
    Route::get('/tasks/{task}/timeline', [ActivityController::class, 'timeline'])->whereNumber('task')->name('tasks.timeline');
});
