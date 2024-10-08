<?php


declare(strict_types=1);

namespace App\Actions\Article;

use Carbon\Carbon;
use DateTimeInterface;
use App\Data\Article\CreateArticleData;
use App\Gamify\Points\ArticleCreated;
use App\Models\Article;
use App\Notifications\PostArticleToTelegram;
use Illuminate\Support\Facades\Auth;

final class CreateArticleAction
{
    public function execute(CreateArticleData $articleData): Article
    {
        if ($articleData->published_at && !($articleData->published_at instanceof DateTimeInterface)) {
            $articleData->published_at = new Carbon(
                time: $articleData->published_at,
                tz: config('app.timezone')
            );
        }

        /** @var Article $article */
        $article = Article::query()->create([
            'title' => $articleData->title,
            'slug' => $articleData->title,
            'body' => $articleData->body,
            'published_at' => $articleData->published_at,
            'submitted_at' => $articleData->submitted_at,
            'approved_at' => $articleData->approved_at,
            'show_toc' => $articleData->show_toc,
            'canonical_url' => $articleData->canonical_url,
            'user_id' => Auth::id(),
        ]);

        if (collect($article->associateTags)->isNotEmpty()) {
            $article->syncTags(tags: $article->associateTags);
        }

        if ($article->file) {
            $article->addMedia($article->file->getRealPath())->toMediaCollection('media');
        }

        if ($article->isAwaitingApproval()) {
            // Envoi de la notification sur le channel Telegram pour la validation de l'article.
            Auth::user()?->notify(new PostArticleToTelegram($article));
            session()->flash('status', __('Merci d\'avoir soumis votre article. Vous aurez des nouvelles que lorsque nous accepterons votre article.'));
        }

        if (Auth::user()?->hasAnyRole(['admin', 'moderator'])) {
            givePoint(new ArticleCreated($article));
        }


        return $article;
    }
}
