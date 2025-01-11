<?php

declare(strict_types=1);

use App\Livewire\Pages\Account;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'checkIfBanned', 'verified'])->group(function (): void {
    Route::get('/settings', Account\Settings::class)->name('settings');
    Route::get('/dashboard', Account\Dashboard::class)->name('dashboard');
});

Route::get('/@{user:username}', Account\Profile::class)->name('profile');
