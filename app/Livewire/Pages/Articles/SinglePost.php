<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Articles;

use App\Models\Article;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class SinglePost extends Component
{
    public Article $article;

    public function mount(Article $article): void
    {
        /** @var User $user */
        $user = Auth::user();

        $article = $article->load(['media', 'user'])->loadCount('views');

        abort_unless(
            $article->isPublished() || ($user && $article->isAuthoredBy($user)) || ($user && $user->hasAnyRole(['admin', 'moderator'])), // @phpstan-ignore-line
            404
        );

        if ($article->isPublished()) {
            views($article)->cooldown(now()->addHours(2))->record();
        }

        $image = empty($article->getFirstMediaUrl('media'))
            ? $article->getFirstMediaUrl('media')
            : asset('/images/socialcard.png');

        // @phpstan-ignore-next-line
        seo()
            ->title($article->title)
            ->description($article->excerpt(150))
            ->image($image)
            ->twitterTitle($article->title)
            ->twitterDescription($article->excerpt(150))
            ->twitterImage($image)
            ->twitterSite('laravelcd')
            ->url($article->canonicalUrl());

        $this->article = $article;
    }

    public function render(): View
    {
        return view('livewire.pages.articles.single-post')->title($this->article->title);
    }
}
