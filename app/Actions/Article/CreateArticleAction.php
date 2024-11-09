<?php

declare(strict_types=1);

namespace App\Actions\Article;

use App\Data\CreateArticleData;
use App\Models\Article;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

final class CreateArticleAction
{
    public function execute(CreateArticleData $articleData): Article
    {
        if ($articleData->published_at) {
            $articleData->published_at = new Carbon(
                time: $articleData->published_at,
                timezone: config('app.timezone')
            );
        }

        /** @var User $author */
        $author = Auth::user();

        /** @var Article $article */
        $article = Article::query()->create([
            'title' => $articleData->title,
            'slug' => $articleData->slug,
            'body' => $articleData->body,
            'published_at' => $articleData->published_at,
            'submitted_at' => $articleData->is_draft ? null : now(),
            'canonical_url' => $articleData->canonical_url,
            'user_id' => $author->id,
        ]);

        return $article;
    }
}
