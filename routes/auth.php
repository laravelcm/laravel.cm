<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\OAuthController;
use App\Livewire\Pages\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('auth/{provider}', [OAuthController::class, 'redirectToProvider'])->name('social.auth');
Route::get('auth/{provider}/callback', [OAuthController::class, 'handleProviderCallback']);

Route::middleware('guest')->group(function (): void {
    Route::get('register', Auth\Register::class)->name('register');
    Route::get('login', Auth\Login::class)->name('login');
    Route::get('forgot-password', Auth\ForgotPassword::class)->name('password.request');
    Route::get('reset-password/{token}', Auth\ResetPassword::class)->name('password.reset');
});

Route::middleware(['auth', 'checkIfBanned'])->group(function (): void {
    Volt::route('verify-email', 'pages.auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', function (Illuminate\Http\Request $request) {
        /** @var App\Models\User $user */
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard.index'));
        }

        $user->sendEmailVerificationNotification();

        notify()
            ->title(__('pages/auth.verify.success'))
            ->success()
            ->send();

        return back();
    })->middleware('throttle:6,1')->name('verification.send');

    Volt::route('confirm-password', 'pages.auth.confirm-password')
        ->name('password.confirm');
});
