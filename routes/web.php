<?php

use App\Http\Controllers\ArticlesController;
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
Route::view('terms', 'terms')->name('terms');
Route::view('rules', 'rules')->name('rules');
Route::view('privacy', 'privacy')->name('privacy');
Route::view('faq', 'faq')->name('faq');

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

// User settings
Route::prefix('settings')->as('user.')->group(function () {
    Route::get('/', [User\SettingController::class, 'profile'])->name('settings');
    Route::put('/', [User\SettingController::class, 'update'])->name('settings.update');
});

// Redirect Route
Route::redirectMap([
    '.env' => 'https://www.youtube.com/watch?v=M8ogFbLP9XQ',
    'wp-login' => 'https://www.youtube.com/watch?v=M8ogFbLP9XQ',
    'wp-admin' => 'https://www.youtube.com/watch?v=M8ogFbLP9XQ',
    'facebook' => 'https://facebook.com/laravelcm',
    'twitter' => 'https://twitter.com/laravelcm',
    'telegram' => 'https://t.me/joinchat/UnTRApWa50zoRO0I',
    'slack' => 'https://laravelcm.slack.com',
    'linkedin' => 'https://www.linkedin.com/company/laravel-cameroun',
    'github' => 'https://github.com/laravelcm',
    'youtube' => 'https://www.youtube.com/channel/UCbQPQ8q31uQmuKtyRnATLSw',
]);

Route::mediaLibrary();
