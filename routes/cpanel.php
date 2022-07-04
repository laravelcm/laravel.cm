<?php

use App\Http\Controllers\Cpanel\DashboardController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'cpanel/home');
Route::get('/home', DashboardController::class)->name('home');
