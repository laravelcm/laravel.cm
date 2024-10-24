<?php

declare(strict_types=1);

namespace App\Actions\Article;

use App\Data\Article\CreateArticleData;
use App\Gamify\Points\ArticleCreated;
use App\Models\Article;
use App\Notifications\PostArticleToTelegram;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

final class CreateArticleAction
{
    public function execute(CreateArticleData $articleData): Article
    {
        if ($articleData->publishedAt) {
            $articleData->publishedAt = new Carbon(
                time: $articleData->publishedAt,
                tz: config('app.timezone')
            );
        }

        /** @var Article $article */
        $article = Article::query()->create([
            'title' => $articleData->title,
            'slug' => $articleData->title,
            'body' => $articleData->body,
            'published_at' => $articleData->publishedAt,
            'submitted_at' => $articleData->submittedAt,
            'approved_at' => $articleData->approvedAt,
            'show_toc' => $articleData->showToc,
            'canonical_url' => $articleData->canonicalUrl,
            'user_id' => Auth::id(),
        ]);

        if (collect($articleData->tags)->isNotEmpty()) {
            $article->syncTags(tags: $articleData->tags);
        }

        if ($articleData->file) {
            $article->addMedia($articleData->file->getRealPath())
                ->toMediaCollection('media');
        }

        if ($article->isAwaitingApproval()) {
            // Envoi de la notification sur le channel Telegram pour la validation de l'article.
            Auth::user()?->notify(new PostArticleToTelegram($article));

            session()->flash('status', __('notifications.article.created'));
        }

        if (Auth::user()?->hasAnyRole(['admin', 'moderator'])) {
            givePoint(new ArticleCreated($article));
        }

        return $article;
    }
}
