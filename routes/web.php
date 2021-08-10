<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OAuthController;
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
