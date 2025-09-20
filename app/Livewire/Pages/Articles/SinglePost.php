<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Articles;

use App\Models\Article;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

final class SinglePost extends Component
{
    public Article $article;

    public function mount(): void
    {
        /** @var User $user */
        $user = Auth::user();

        $article = Cache::rememberForever(
            key: 'article.'.$this->article->id,
            callback: fn (): Article => $this->article->load('user:id,name,username,avatar_type', 'tags', 'media')->loadCount('views'),
        );

        abort_unless(
            $article->isPublished() || ($user && $article->isAuthoredBy($user)) || ($user && $user->hasAnyRole(['admin', 'moderator'])), // @phpstan-ignore-line
            404
        );

        if ($article->isPublished()) {
            views($article)->cooldown(now()->addHours(2))->record();
        }

        $image = blank($article->getFirstMediaUrl('media'))
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
            ->url($article->canonicalUrl());

        $this->article = $article;
    }

    public function render(): View
    {
        return view('livewire.pages.articles.single-post')->title($this->article->title);
    }
}
