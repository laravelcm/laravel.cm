<?php

declare(strict_types=1);

use App\Http\Controllers\NotchPayCallBackController;
use App\Http\Controllers\ReplyAbleController;
use App\Http\Controllers\SubscriptionController;
use App\Livewire\Pages;
use Illuminate\Support\Facades\Route;

Route::get('/', Pages\Home::class)->name('home');
Route::view('a-propos', 'pages.about')->name('about');
Route::view('privacy', 'pages.privacy')->name('privacy');
Route::view('rules', 'pages.rules')->name('rules');
Route::view('terms', 'pages.terms')->name('terms');

Route::prefix('articles')->as('articles.')->group(function (): void {
    Route::get('/', Pages\Articles\Index::class)->name('index');
    Route::get('/tags/{tag:slug}', Pages\Articles\SingleTag::class)->name('tag');
    Route::get('/{article}', Pages\Articles\SinglePost::class)->name('show');
});
Route::prefix('discussions')->as('discussions.')->group(function (): void {
    Route::get('/', Pages\Discussions\Index::class)->name('index');
    Route::get('/{discussion}', Pages\Discussions\SingleDiscussion::class)->name('show');
});
Route::prefix('forum')->as('forum.')->group(function (): void {
    Route::get('/', Pages\Forum\Index::class)->name('index');
    Route::get('/channels', Pages\Forum\Channels::class)->name('channels');
    // Route::get('/leaderboard', Pages\Forum\Leaderboard::class)->name('leaderboard');
    Route::get('/{thread}', Pages\Forum\DetailThread::class)->name('show');
});

Route::get('replyable/{id}/{type}', ReplyAbleController::class)->name('replyable');
Route::get('subscriptions/{subscription}/unsubscribe', [SubscriptionController::class, 'unsubscribe'])
    ->name('subscriptions.unsubscribe');
Route::get('subscribeable/{id}/{type}', [SubscriptionController::class, 'redirect'])->name('subscriptions.redirect');
Route::get('notifications', Pages\Notifications::class)
    ->name('notifications')
    ->middleware(['auth', 'checkIfBanned']);

Route::get('sponsors', Pages\Sponsoring::class)->name('sponsors');
Route::get('callback-payment', NotchPayCallBackController::class)->name('notchpay-callback');

Route::middleware(['auth', 'checkIfBanned', 'verified'])->group(function (): void {
    Route::get('/dashboard', Pages\Account\Dashboard::class)->name('dashboard');
    Route::prefix('account')->as('account.')->group(function (): void {
        Route::get('/', Pages\Account\Index::class)->name('index');
        Route::get('/password', Pages\Account\Password::class)->name('password');
        Route::get('/preferences', Pages\Account\Preferences::class)->name('preferences');
        Route::get('/alerts', Pages\Account\Alerts::class)->name('alerts');
    });
});

Route::get('/@{user:username}', Pages\Account\Profile::class)->name('profile');

require __DIR__.'/auth.php';

Route::feeds();
