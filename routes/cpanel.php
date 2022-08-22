<?php

use App\Http\Controllers\Cpanel;
use Illuminate\Support\Facades\Route;
use Spatie\Health\Http\Controllers\HealthCheckResultsController;

Route::redirect('/', 'cpanel/home');
Route::get('/home', Cpanel\DashboardController::class)->name('home');
Route::get('/analytics', Cpanel\AnalyticsController::class)->name('analytics');
Route::prefix('users')->as('users.')->group(function () {
    Route::get('/', Cpanel\UserController::class)->name('browse');
});
Route::get('health', HealthCheckResultsController::class);
