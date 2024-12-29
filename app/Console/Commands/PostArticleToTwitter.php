<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Article;
use App\Notifications\PostArticleToTwitter as PostArticleToTwitterNotification;
use Illuminate\Console\Command;
use Illuminate\Notifications\AnonymousNotifiable;

final class PostArticleToTwitter extends Command
{
    protected $signature = 'lcd:post-article-to-twitter';

    protected $description = 'Posts the latest unshared article to Twitter';

    public function handle(AnonymousNotifiable $notifiable): void
    {
        if ($article = Article::nextForSharing()) {
            $notifiable->notify(new PostArticleToTwitterNotification($article));

            $article->markAsShared();
        }
    }
}
