<?php

declare(strict_types=1);

use App\Livewire\Pages\Forum;
use Illuminate\Support\Facades\Route;

Route::get('/', Forum\Index::class)->name('index');
Route::get('/channels', Forum\Channels::class)->name('channels');
Route::get('/{thread}', Forum\DetailThread::class)->name('show');
