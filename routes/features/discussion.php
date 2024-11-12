<?php

declare(strict_types=1);

use App\Http\Controllers\DiscussionController;
use App\Livewire\Pages\Discussions;
use Illuminate\Support\Facades\Route;

Route::get('/', Discussions\Index::class)->name('index');
Route::get('/new', [DiscussionController::class, 'create'])->name('new');
Route::get('/{discussion}', Discussions\SingleDiscussion::class)->name('show');
Route::get('/{discussion}/edit', [DiscussionController::class, 'edit'])->name('edit');
