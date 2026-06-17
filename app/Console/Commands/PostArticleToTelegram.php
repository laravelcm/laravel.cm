<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Article;
use App\Notifications\PostArticleToTelegram as PostArticleToTelegramNotification;
use Illuminate\Console\Command;
use Illuminate\Notifications\AnonymousNotifiable;

#[\Illuminate\Console\Attributes\Description('Posts the latest shared article to Telegram')]
#[\Illuminate\Console\Attributes\Signature('lcm:post-article-to-telegram')]
final class PostArticleToTelegram extends Command
{
    public function handle(AnonymousNotifiable $notifiable): void
    {
        $article = Article::nexForSharingToTelegram();

        if ($article instanceof Article && app()->isProduction()) {
            $notifiable->notify(new PostArticleToTelegramNotification($article));
            $article->markAsPublish();
        }
    }
}
