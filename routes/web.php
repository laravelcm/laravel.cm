<?php

declare(strict_types=1);

use App\Http\Controllers\NotchPayCallBackController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\ReplyAbleController;
use App\Http\Controllers\SubscriptionController;
use App\Livewire\Pages\Home;
use App\Livewire\Pages\Notifications;
use App\Livewire\Pages\Sponsoring;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', Home::class)->name('home');

// Static pages
Volt::route('a-propos', 'pages.about')->name('about');
Route::view('privacy', 'pages.privacy')->name('privacy');
Route::view('rules', 'pages.rules')->name('rules');
Route::view('terms', 'pages.terms')->name('terms');

// Social authentication
Route::get('auth/{provider}', [OAuthController::class, 'redirectToProvider'])->name('social.auth');
Route::get('auth/{provider}/callback', [OAuthController::class, 'handleProviderCallback']);

// Articles
Route::prefix('articles')->as('articles.')->group(base_path('routes/features/article.php'));
Route::prefix('discussions')->as('discussions.')->group(base_path('routes/features/discussion.php'));
Route::prefix('forum')->as('forum.')->group(base_path('routes/features/forum.php'));

// Replies
Route::get('replyable/{id}/{type}', ReplyAbleController::class)->name('replyable');

// Subscriptions
Route::get('subscriptions/{subscription}/unsubscribe', [SubscriptionController::class, 'unsubscribe'])
    ->name('subscriptions.unsubscribe');
Route::get('subscribeable/{id}/{type}', [SubscriptionController::class, 'redirect'])->name('subscriptions.redirect');

// Notifications
Route::get('notifications', Notifications::class)
    ->name('notifications')
    ->middleware(['auth', 'checkIfBanned']);

Route::get('sponsors', Sponsoring::class)->name('sponsors');
Route::get('callback-payment', NotchPayCallBackController::class)->name('notchpay-callback');

require __DIR__.'/features/account.php';

require __DIR__.'/auth.php';

Route::feeds();
