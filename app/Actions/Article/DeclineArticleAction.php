<?php

declare(strict_types=1);

namespace App\Actions\Article;

use App\Models\Article;
use App\Notifications\ArticleDeclinedNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

final class DeclineArticleAction
{
    public function execute(string $reason, Article $article): Article
    {
        return DB::transaction(function () use ($reason, $article): Article {
            $article->update([
                'declined_at' => Carbon::now(),
                'reason' => $reason,
                'submitted_at' => null,
            ]);

            $article->user->notify(new ArticleDeclinedNotification($article));

            $article->refresh();

            return $article;
        });
    }
}
