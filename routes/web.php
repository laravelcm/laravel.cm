<?php

declare(strict_types=1);

use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotchPayCallBackController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\ReplyAbleController;
use App\Http\Controllers\SlackController;
use App\Http\Controllers\SponsoringController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

// Static pages
Route::view('a-propos', 'about')->name('about');
Route::view('faq', 'faq')->name('faq');
Route::view('privacy', 'privacy')->name('privacy');
Route::view('rules', 'rules')->name('rules');
Route::view('terms', 'terms')->name('terms');
Route::view('slack', 'slack')->name('slack');
Route::post('slack', SlackController::class)->name('slack.send');
Route::post('uploads/process', [FileUploadController::class, 'process'])
    ->middleware('auth')
    ->name('uploads.process');

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
Route::get('notifications', \App\Livewire\Pages\Notifications::class)
    ->name('notifications')
    ->middleware(['auth', 'checkIfBanned']);

Route::feeds();

Route::get('sponsors', [SponsoringController::class, 'sponsors'])->name('sponsors');
Route::get('callback-payment', NotchPayCallBackController::class)->name('notchpay-callback');

require __DIR__.'/features/account.php';

require __DIR__.'/auth.php';
