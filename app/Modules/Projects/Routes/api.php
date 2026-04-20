<?php

use App\Modules\Projects\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'verified'])->group(function () {
    Route::apiResource('projects', ProjectController::class)->whereNumber('project');

    // Member management
    Route::post('/projects/{project}/members', [ProjectController::class, 'addMember'])->whereNumber('project')->name('projects.addMember');
    Route::delete('/projects/{project}/members/{userId}', [ProjectController::class, 'removeMember'])->whereNumber('project')->name('projects.removeMember');
    Route::get('/projects/{project}/members', [ProjectController::class, 'getMembers'])->whereNumber('project')->name('projects.getMembers');
});
