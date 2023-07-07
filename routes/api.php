<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Auth\VerifyEmailController;
use App\Http\Controllers\Api\Enterprise;
use App\Http\Controllers\Api\PremiumController;
use App\Http\Controllers\Api\User\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('premium-users', [PremiumController::class, 'users']);

/** Authentication Routes */
Route::post('login', [LoginController::class, 'login']);
Route::get('email/verify/{id}/{hash}', [VerifyEmailController::class, 'verify'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');
Route::prefix('register')->group(function (): void {
    Route::post('/', [RegisterController::class, 'register']);
    Route::post('google', [RegisterController::class, 'googleAuthenticator']);
});
Route::prefix('password')->group(function (): void {
    Route::post('forgot', ForgotPasswordController::class);
    Route::post('reset', ResetPasswordController::class);
});

/* Authenticated Routes */
Route::middleware('auth:sanctum')->group(function (): void {
    Route::post('logout', [LoginController::class, 'logout']);
    Route::get('email/verify/resend', [VerifyEmailController::class, 'resend'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    /** User Profile Api */
    Route::prefix('user')->group(function (): void {
        Route::get('me', [ProfileController::class, 'me']);
        Route::get('roles', [ProfileController::class, 'roles']);
    });
});

/** Public SPA Api */
Route::prefix('enterprises')->group(function (): void {
    Route::get('featured', [Enterprise\PublicController::class, 'featured']);
    Route::get('paginate', [Enterprise\PublicController::class, 'paginate']);

    Route::middleware('auth:sanctum')->group(function (): void {
        Route::post('add', Enterprise\RegisterController::class);
    });
});
