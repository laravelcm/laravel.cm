<?php

use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\Forum\ReplyController;
use App\Http\Controllers\Forum\ThreadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Static pages
Route::view('a-propos', 'about')->name('about');
Route::view('faq', 'faq')->name('faq');
Route::view('privacy', 'privacy')->name('privacy');
Route::view('rules', 'rules')->name('rules');
Route::view('terms', 'terms')->name('terms');
Route::view('slack', 'slack')->name('slack');
Route::post('slack', [HomeController::class, 'slack'])->name('slack.send');

// Social authentication
Route::get('auth/{provider}', [OAuthController::class, 'redirectToProvider'])->name('social.auth');
Route::get('auth/{provider}/callback', [OAuthController::class, 'handleProviderCallback']);

// Articles
Route::prefix('articles')->group(function () {
    Route::get('/', [ArticlesController::class, 'index'])->name('articles');
    Route::get('/new', [ArticlesController::class, 'create'])->name('articles.new');
    Route::post('/new', [ArticlesController::class, 'store'])->name('articles.store');
    Route::get('/{article}', [ArticlesController::class, 'show'])->name('articles.show');
    Route::get('/{article}/edit', [ArticlesController::class, 'edit'])->name('articles.edit');
});

// Forum
Route::prefix('forum')->as('forum.')->group(function () {
    Route::redirect('/channels', '/forum');
    Route::get('/', [ThreadController::class, 'index'])->name('index');
    Route::get('/channels/{channel}', [ThreadController::class, 'channel'])->name('channels');
    Route::get('/new-thread', [ThreadController::class, 'create'])->name('new');
    Route::get('/{thread}', [ThreadController::class, 'show'])->name('show');
    Route::get('/{thread}/edit', [ThreadController::class, 'edit'])->name('edit');
});

// Replies
Route::post('replies', [ReplyController::class, 'store'])->name('replies.store');

// Settings
Route::prefix('settings')->as('user.')->middleware('auth')->group(function () {
    Route::get('/', [User\SettingController::class, 'profile'])->name('settings');
    Route::put('/', [User\SettingController::class, 'update'])->name('settings.update');
    Route::view('/customization', 'user.settings.customization')->name('customization');
    Route::get('/password', [User\SettingController::class, 'password'])->name('password');
    Route::put('/password', [User\SettingController::class, 'updatePassword'])->name('password.update');
});

// User
Route::redirect('/dashboard', '/user');
Route::get('/user/{username?}', [User\ProfileController::class, 'show'])->name('profile');

// Redirect Route
Route::redirectMap([
    '.env' => 'https://www.youtube.com/watch?v=M8ogFbLP9XQ',
    'wp-login' => 'https://www.youtube.com/watch?v=M8ogFbLP9XQ',
    'wp-admin' => 'https://www.youtube.com/watch?v=M8ogFbLP9XQ',
    'facebook' => 'https://facebook.com/laravelcm',
    'twitter' => 'https://twitter.com/laravelcm',
    'telegram' => 'https://t.me/joinchat/UnTRApWa50zoRO0I',
    'linkedin' => 'https://www.linkedin.com/company/laravel-cameroun',
    'github' => 'https://github.com/laravelcm',
    'youtube' => 'https://www.youtube.com/channel/UCbQPQ8q31uQmuKtyRnATLSw',
]);

Route::mediaLibrary();
// In routes/web.php
Route::feeds();
