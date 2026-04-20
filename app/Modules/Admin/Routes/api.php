<?php

use App\Modules\Admin\Http\Controllers\AdminController;
use App\Modules\Admin\Http\Controllers\ExportController;
use App\Modules\Admin\Http\Controllers\UserControlController;
use App\Modules\Admin\Http\Controllers\ImpersonationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/admin/users', [AdminController::class, 'users']);
    Route::patch('/admin/users/{id}/role', [AdminController::class, 'updateRole']);
    Route::delete('/admin/users/{id}', [AdminController::class, 'deactivate']);
    Route::get('/admin/stats', [AdminController::class, 'stats']);
    Route::get('/admin/users/export/csv', [ExportController::class, 'exportUsersCsv']);
    Route::post('/admin/users/{id}/force-password-reset', [UserControlController::class, 'forcePasswordReset']);
    Route::post('/admin/users/{id}/impersonate', [ImpersonationController::class, 'start']);
    Route::post('/admin/impersonate/stop', [ImpersonationController::class, 'stop']);
});
