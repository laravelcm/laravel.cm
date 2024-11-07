<?php

declare(strict_types=1);

use App\Http\Controllers\ArticlesController;
use App\Livewire\Pages\Articles;
use Illuminate\Support\Facades\Route;

Route::get('/', Articles\Index::class)->name('index');
Route::get('/tags/{tag:slug}', Articles\SingleTag::class)->name('tag');
Route::get('/{article}', Articles\SinglePost::class)->name('show');

Route::get('/new', [ArticlesController::class, 'create'])->name('new');
Route::get('/{article}/edit', [ArticlesController::class, 'edit'])->name('edit');
