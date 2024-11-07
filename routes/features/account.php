<?php

declare(strict_types=1);

use App\Http\Controllers\User;
use App\Livewire\Pages\Account;
use Illuminate\Support\Facades\Route;

// Settings
Route::prefix('settings')->as('user.')->middleware('auth')->group(function (): void {
    Route::get('/', [User\SettingController::class, 'profile'])->name('settings');
    Route::put('/', [User\SettingController::class, 'update'])->name('settings.update');
    Route::view('/customization', 'user.settings.customization')->name('customization')->middleware('verified');
    Route::view('/notifications', 'user.settings.notifications')->name('notifications')->middleware('verified');
    Route::get('/password', [User\SettingController::class, 'password'])->name('password')->middleware('verified');
    Route::put('/password', [User\SettingController::class, 'updatePassword'])->name('password.update');
});

// User
Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function (): void {
    Route::get('/', Account\Dashboard::class)->name('dashboard');
    // Route::get('/', [User\DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/threads', [User\DashboardController::class, 'threads'])->name('threads.me');
    Route::get('/discussions', [User\DashboardController::class, 'discussions'])->name('discussions.me');
});

Route::get('/user/{username?}', [User\ProfileController::class, 'show'])->name('profile');
