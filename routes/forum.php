<?php

declare(strict_types=1);

use App\Http\Controllers\ThreadController;
use App\Livewire\Pages\Forum;
use Illuminate\Support\Facades\Route;

Route::get('/', Forum\Index::class)->name('index');
Route::get('/channels/{channel}', [ThreadController::class, 'channel'])->name('channels');
Route::get('/{thread}', Forum\DetailThread::class)->name('show');

Route::get('/{thread}/edit', [ThreadController::class, 'edit'])->name('edit');
