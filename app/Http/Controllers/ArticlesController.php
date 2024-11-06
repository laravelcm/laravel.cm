<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Article;
use App\Policies\ArticlePolicy;
use Illuminate\Contracts\View\View;

final class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified'], ['except' => ['index', 'show']]);
    }

    public function create(): View
    {
        return view('articles.new');
    }

    public function edit(Article $article): View
    {
        $this->authorize(ArticlePolicy::UPDATE, $article);

        return view('articles.edit', compact('article'));
    }
}
