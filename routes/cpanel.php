<?php

use App\Http\Controllers\Cpanel\DashboardController;
use App\Http\Controllers\Cpanel\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'cpanel/home');
Route::get('/home', DashboardController::class)->name('home');
Route::prefix('users')->as('users.')->group(function () {
    Route::get('/', UserController::class)->name('browse');
});
