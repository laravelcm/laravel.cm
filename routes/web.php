<?php

declare(strict_types=1);

use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotchPayCallBackController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\ReplyAbleController;
use App\Http\Controllers\SlackController;
use App\Http\Controllers\SponsoringController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\User;
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
Route::prefix('articles')->group(function (): void {
    Route::get('/', [ArticlesController::class, 'index'])->name('articles');
    Route::get('/new', [ArticlesController::class, 'create'])->name('articles.new');
    Route::get('/{article}', [ArticlesController::class, 'show'])->name('articles.show');
    Route::get('/{article}/edit', [ArticlesController::class, 'edit'])->name('articles.edit');
});

// Discussions
Route::prefix('discussions')->as('discussions.')->group(function (): void {
    Route::get('/', [DiscussionController::class, 'index'])->name('index');
    Route::get('/new', [DiscussionController::class, 'create'])->name('new');
    Route::get('/{discussion}', [DiscussionController::class, 'show'])->name('show');
    Route::get('/{discussion}/edit', [DiscussionController::class, 'edit'])->name('edit');
});

// Forum
Route::prefix('forum')->as('forum.')->group(function (): void {
    Route::redirect('/channels', '/forum');
    Route::get('/', [ThreadController::class, 'index'])->name('index');
    Route::get('/channels/{channel}', [ThreadController::class, 'channel'])->name('channels');
    Route::get('/new-thread', [ThreadController::class, 'create'])->name('new');
    Route::get('/{thread}', [ThreadController::class, 'show'])->name('show');
    Route::get('/{thread}/edit', [ThreadController::class, 'edit'])->name('edit');
});

// Replies
Route::get('replyable/{id}/{type}', [ReplyAbleController::class, 'redirect'])->name('replyable');

// Subscriptions
Route::get('subscriptions/{subscription}/unsubscribe', [SubscriptionController::class, 'unsubscribe'])
    ->name('subscriptions.unsubscribe');
Route::get('subscribeable/{id}/{type}', [SubscriptionController::class, 'redirect'])->name('subscriptions.redirect');

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
    Route::get('/', [User\DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/threads', [User\DashboardController::class, 'threads'])->name('threads.me');
    Route::get('/discussions', [User\DashboardController::class, 'discussions'])->name('discussions.me');
});
Route::get('/user/{username?}', [User\ProfileController::class, 'show'])->name('profile');

// Notifications
Route::view('notifications', 'user.notifications')->name('notifications')->middleware('auth');

// Redirect Route
Route::redirectMap([
    '.env' => 'https://www.youtube.com/watch?v=M8ogFbLP9XQ',
    'wp-login' => 'https://www.youtube.com/watch?v=M8ogFbLP9XQ',
    'wp-admin' => 'https://www.youtube.com/watch?v=M8ogFbLP9XQ',
    'facebook' => 'https://facebook.com/laravelcm',
    'twitter' => 'https://twitter.com/laravelcm',
    'telegram' => 'https://t.me/laravelcameroun',
    'linkedin' => 'https://www.linkedin.com/company/laravel-cameroun',
    'github' => 'https://github.com/laravelcm',
    'whatsapp' => 'https://chat.whatsapp.com/G8e98Ms0MgSLEOGd3Uai1i',
    'discord' => 'https://discord.gg/KNp6brbyVD',
    'youtube' => 'https://www.youtube.com/channel/UCbQPQ8q31uQmuKtyRnATLSw',
]);

Route::feeds();

Route::get('sponsors', [SponsoringController::class, 'sponsors'])->name('sponsors');
Route::get('callback-payment', NotchPayCallBackController::class)->name('notchpay-callback');
