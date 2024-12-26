<?php

declare(strict_types=1);

use App\Livewire\Pages\Articles;
use Illuminate\Support\Facades\Route;

Route::get('/', Articles\Index::class)->name('index');
Route::get('/tags/{tag:slug}', Articles\SingleTag::class)->name('tag');
Route::get('/{article}', Articles\SinglePost::class)->name('show');
