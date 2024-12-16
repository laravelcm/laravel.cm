<?php

declare(strict_types=1);

use App\Http\Controllers\DiscussionController;
use App\Livewire\Pages\Discussions;
use Illuminate\Support\Facades\Route;

Route::get('/', Discussions\Index::class)->name('index');
Route::get('/{discussion}', Discussions\SingleDiscussion::class)->name('show');
