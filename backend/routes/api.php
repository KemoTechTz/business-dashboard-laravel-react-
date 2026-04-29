<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ServiceCatalogController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function (): void {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function (): void {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    });
});

Route::middleware(['auth:sanctum', 'tenant'])->group(function (): void {
    Route::get('/dashboard/summary', [DashboardController::class, 'summary']);
    Route::get('/dashboard/export/{format}', [DashboardController::class, 'export']);
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('services', ServiceCatalogController::class);
    Route::apiResource('bookings', BookingController::class);
    Route::apiResource('payments', PaymentController::class)->except(['destroy']);

    Route::get('/settings/business', [SettingsController::class, 'businessProfile']);
    Route::put('/settings/business', [SettingsController::class, 'updateBusinessProfile']);
    Route::get('/settings/users', [SettingsController::class, 'users']);
    Route::put('/settings/users/{user}/role', [SettingsController::class, 'updateUserRole'])->middleware('role:admin');
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markRead']);
});
