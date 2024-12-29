<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Article;
use App\Notifications\PostArticleToTelegram as PostArticleToTelegramNotification;
use Illuminate\Console\Command;
use Illuminate\Notifications\AnonymousNotifiable;

final class PostArticleToTelegram extends Command
{
    protected $signature = 'lcd:post-article-to-telegram';

    protected $description = 'Posts the latest shared article to Telegram';

    public function handle(AnonymousNotifiable $notifiable): void
    {
        if (app()->environment('production')) {
            if ($article = Article::nexForSharingToTelegram()) {
                $notifiable->notify(new PostArticleToTelegramNotification($article));

                $article->markAsPublish();
            }
        }
    }
}
