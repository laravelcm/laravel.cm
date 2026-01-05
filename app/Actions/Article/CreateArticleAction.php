<?php

declare(strict_types=1);

namespace App\Actions\Article;

use App\Data\ArticleData;
use App\Models\Article;
use App\Models\User;

final class CreateArticleAction
{
    public function execute(ArticleData $data, User $user): Article
    {
        if (filled($data->published_at) && ($user->isAdmin() || $user->isModerator())) {
            $data->approved_at = now();
        }

        /** @var Article */
        return Article::query()->create([
            'title' => $data->title,
            'slug' => $data->slug,
            'body' => $data->body,
            'locale' => $data->locale,
            'published_at' => $data->published_at,
            'submitted_at' => $data->submitted_at,
            'approved_at' => $data->approved_at,
            'canonical_url' => $data->canonical_url,
            'user_id' => $user->id,
        ]);
    }
}
