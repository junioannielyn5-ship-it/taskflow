<?php

use App\Modules\Identity\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->name('identity.')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        
        // Admin-only routes
        Route::middleware('role:admin')->group(function () {
            Route::get('/admin/dashboard', function () {
                return response()->json(['message' => 'Admin dashboard']);
            })->name('admin.dashboard');
        });
    });
});
