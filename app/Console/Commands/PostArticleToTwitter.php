<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Article;
use App\Notifications\PostArticleToTwitter as PostArticleToTwitterNotification;
use Illuminate\Console\Command;
use Illuminate\Notifications\AnonymousNotifiable;

#[\Illuminate\Console\Attributes\Description('Posts the latest unshared article to Twitter')]
#[\Illuminate\Console\Attributes\Signature('lcm:post-article-to-twitter')]
final class PostArticleToTwitter extends Command
{
    public function handle(AnonymousNotifiable $notifiable): void
    {
        $article = Article::nextForSharing();

        if ($article instanceof Article && app()->isProduction()) {
            $notifiable->notify(new PostArticleToTwitterNotification($article));
            $article->markAsShared();
        }
    }
}
