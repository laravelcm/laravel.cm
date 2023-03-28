<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use App\Policies\ArticlePolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified'], ['except' => ['index', 'show']]);
    }

    public function index()
    {
        return view('articles.index');
    }

    public function show(Article $article)
    {
        /** @var User $user */
        $user = Auth::user();

        views($article)->record();

        /** @var Article $article */
        $article = Cache::remember('post-'.$article->id, now()->addHour(), fn () => $article);

        abort_unless(
            $article->isPublished() || ($user && $article->isAuthoredBy($user)) || ($user && $user->hasAnyRole(['admin', 'moderator'])), // @phpstan-ignore-line
            404
        );

        $image = $article->getFirstMediaUrl('media') ?? asset('images/socialcard.png');
        seo()
            ->title($article->title)
            ->description($article->excerpt(100))
            ->image($image)
            ->twitterTitle($article->title)
            ->twitterDescription($article->excerpt(100))
            ->twitterImage($image)
            ->twitterSite('laravelcm')
            ->withUrl();

        return view('articles.show', [
            'article' => $article->loadCount('views'),
        ]);
    }

    public function create()
    {
        return view('articles.new');
    }

    public function edit(Article $article)
    {
        $this->authorize(ArticlePolicy::UPDATE, $article);

        return view('articles.edit', compact('article'));
    }
}
