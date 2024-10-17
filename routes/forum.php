<?php

declare(strict_types=1);

use App\Http\Controllers\ThreadController;
use App\Livewire\Pages\Forum;
use Illuminate\Support\Facades\Route;

Route::get('/', Forum\Index::class)->name('index');

Route::get('/channels/{channel}', [ThreadController::class, 'channel'])->name('channels');
Route::get('/new-thread', [ThreadController::class, 'create'])->name('new');
Route::get('/{thread}', [ThreadController::class, 'show'])->name('show');
Route::get('/{thread}/edit', [ThreadController::class, 'edit'])->name('edit');
