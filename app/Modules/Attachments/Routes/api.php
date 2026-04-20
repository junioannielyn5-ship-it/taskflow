<?php

use App\Modules\Attachments\Http\Controllers\AttachmentController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    // Upload attachment to a task
    Route::post('/tasks/{task}/attachments', [AttachmentController::class, 'store']);
    // Download attachment securely
    Route::get('/attachments/{attachment}/download', [AttachmentController::class, 'download']);
    // Delete attachment
    Route::delete('/attachments/{attachment}', [AttachmentController::class, 'destroy']);
});
