<?php

use App\Modules\Reporting\Http\Controllers\ReportingController;
use App\Modules\Reporting\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/reports/overdue', [ReportingController::class, 'overdue']);
    Route::get('/reports/performance', [ReportingController::class, 'performance']);
    Route::get('/reports/cycle-time', [ReportingController::class, 'cycleTime']);
    Route::get('/reports/total-hours', [ReportingController::class, 'totalHours']);
    Route::get('/reports/overdue/export/csv', [ExportController::class, 'exportOverdueCsv']);
});
