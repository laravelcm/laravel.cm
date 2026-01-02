<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Articles;

use App\Models\Article;
use App\Models\User;
use ArchTech\SEO\SEOManager;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Livewire\Component;

final class SinglePost extends Component
{
    public Article $article;

    public function mount(): void
    {
        /** @var User $user */
        $user = Auth::user();

        /** @var Article $article */
        $article = Cache::rememberForever(
            key: 'article.'.$this->article->id,
            callback: fn (): Article => $this->article
                ->load('user:id,name,username,avatar_type', 'tags', 'media')
                ->loadCount('views'),
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

        /** @var SEOManager $seoManager */
        $seoManager = seo();

        $seoManager
            ->title(Str::limit($article->title, 60, ''))
            ->description($article->excerpt(160))
            ->image($image)
            ->twitterTitle(Str::limit($article->title, 60, ''))
            ->twitterDescription($article->excerpt(160))
            ->twitterImage($image)
            ->url($article->canonicalUrl());

        if ($article->isNotPublished()) {
            $seoManager->meta('robots', 'noindex, nofollow');
        }

        $this->article = $article;
    }

    public function render(): View
    {
        return view('livewire.pages.articles.single-post')->title($this->article->title);
    }
}
