<?php

declare(strict_types=1);

use App\Http\Controllers\NotchPayCallBackController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\ReplyAbleController;
use App\Http\Controllers\SubscriptionController;
use App\Livewire\Pages\Account;
use App\Livewire\Pages\Articles;
use App\Livewire\Pages\Discussions;
use App\Livewire\Pages\Forum;
use App\Livewire\Pages\Home;
use App\Livewire\Pages\Notifications;
use App\Livewire\Pages\Sponsoring;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::view('a-propos', 'pages.about')->name('about');
Route::view('privacy', 'pages.privacy')->name('privacy');
Route::view('rules', 'pages.rules')->name('rules');
Route::view('terms', 'pages.terms')->name('terms');

Route::prefix('articles')->as('articles.')->group(function (): void {
    Route::get('/', Articles\Index::class)->name('index');
    Route::get('/tags/{tag:slug}', Articles\SingleTag::class)->name('tag');
    Route::get('/{article}', Articles\SinglePost::class)->name('show');
});
Route::prefix('discussions')->as('discussions.')->group(function (): void {
    Route::get('/', Discussions\Index::class)->name('index');
    Route::get('/{discussion}', Discussions\SingleDiscussion::class)->name('show');
});
Route::prefix('forum')->as('forum.')->group(function (): void {
    Route::get('/', Forum\Index::class)->name('index');
    Route::get('/channels', Forum\Channels::class)->name('channels');
    Route::get('/leaderboard', Forum\Leaderboard::class)->name('leaderboard');
    Route::get('/{thread}', Forum\DetailThread::class)->name('show');
});

Route::get('replyable/{id}/{type}', ReplyAbleController::class)->name('replyable');
Route::get('subscriptions/{subscription}/unsubscribe', [SubscriptionController::class, 'unsubscribe'])
    ->name('subscriptions.unsubscribe');
Route::get('subscribeable/{id}/{type}', [SubscriptionController::class, 'redirect'])->name('subscriptions.redirect');
Route::get('notifications', Notifications::class)
    ->name('notifications')
    ->middleware(['auth', 'checkIfBanned']);

Route::get('sponsors', Sponsoring::class)->name('sponsors');
Route::get('callback-payment', NotchPayCallBackController::class)->name('notchpay-callback');

Route::middleware(['auth', 'checkIfBanned', 'verified'])->group(function (): void {
    Route::get('/settings', Account\Settings::class)->name('settings');
    Route::get('/dashboard', Account\Dashboard::class)->name('dashboard');
});

Route::get('/@{user:username}', Account\Profile::class)->name('profile');

Route::get('auth/{provider}', [OAuthController::class, 'redirectToProvider'])->name('social.auth');
Route::get('auth/{provider}/callback', [OAuthController::class, 'handleProviderCallback']);

require __DIR__.'/auth.php';

Route::feeds();
