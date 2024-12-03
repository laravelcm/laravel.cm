<?php

declare(strict_types=1);

use App\Http\Controllers\User;
use App\Livewire\Pages\Account;
use Illuminate\Support\Facades\Route;

// Settings
/*Route::prefix('settings')->as('user.')->middleware(['auth', 'checkIfBanned'])->group(function (): void {
    Route::put('/', [User\SettingController::class, 'update'])->name('settings.update');
    Route::view('/customization', 'user.settings.customization')->name('customization')->middleware('verified');
    Route::view('/notifications', 'user.settings.notifications')->name('notifications')->middleware('verified');
});*/

Route::middleware(['auth', 'checkIfBanned', 'verified'])->group(function (): void {
    Route::get('/settings', Account\Settings::class)->name('settings');
    Route::get('/dashboard', Account\Dashboard::class)->name('dashboard');
});

// User
Route::prefix('dashboard')->middleware(['auth', 'checkIfBanned', 'verified'])->group(function (): void {
    Route::get('/', Account\Dashboard::class)->name('dashboard');
    // Route::get('/', [User\DashboardController::class, 'dashboard'])->name('dashboard');
    // Route::get('/threads', [User\DashboardController::class, 'threads'])->name('threads.me');
    // Route::get('/discussions', [User\DashboardController::class, 'discussions'])->name('discussions.me');
});

Route::get('/@{user:username?}', Account\Profile::class)->name('profile');
