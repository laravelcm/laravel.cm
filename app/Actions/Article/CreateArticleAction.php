<?php

declare(strict_types=1);

namespace App\Actions\Article;

use App\Data\ArticleData;
use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

final class CreateArticleAction
{
    public function execute(ArticleData $articleData): Article
    {
        if ($articleData->published_at) {
            $articleData->published_at = new Carbon(
                time: $articleData->published_at,
                timezone: config('app.timezone')
            );
        }

        if ($articleData->submitted_at) {
            $articleData->submitted_at = new Carbon(
                time: $articleData->submitted_at,
                timezone: config('app.timezone')
            );
        }

        $user = Auth::user();

        if ($user->isAdmin() || $user->isModerator()) {
            $articleData->published_at = new Carbon(
                time: today(),
                timezone: config('app.timezone')
            );

            $articleData->submitted_at = new Carbon(
                time: $articleData->submitted_at,
                timezone: config('app.timezone')
            );

            $articleData->approved_at = new Carbon(
                time: today(),
                timezone: config('app.timezone')
            );
        }

        // @phpstan-ignore-next-line
        return Article::query()->create([
            'title' => $articleData->title,
            'slug' => $articleData->slug,
            'body' => $articleData->body,
            'published_at' => $articleData->published_at,
            'submitted_at' => $articleData->submitted_at,
            'approved_at' => $articleData->approved_at,
            'canonical_url' => $articleData->canonical_url,
            'user_id' => $user->id,
        ]);
    }
}
