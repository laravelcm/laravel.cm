<?php

declare(strict_types=1);

use App\Http\Controllers\Cpanel;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'cpanel/home');
Route::get('/home', Cpanel\DashboardController::class)->name('home');
Route::get('/analytics', Cpanel\AnalyticsController::class)->name('analytics');
Route::prefix('users')->as('users.')->group(function (): void {
    Route::get('/', Cpanel\UserController::class)->name('browse');
});
