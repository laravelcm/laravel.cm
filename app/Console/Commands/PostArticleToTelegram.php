<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Notifications\PostArticleToTelegram as PostArticleToTelegramNotification;
use Illuminate\Console\Command;
use Illuminate\Notifications\AnonymousNotifiable;

class PostArticleToTelegram extends Command
{
    protected $signature = 'lcm:post-article-to-telegram';

    protected $description = 'Posts the latest unshared article to Telegram';

    public function handle(AnonymousNotifiable $notifiable): void
    {
        if ($article = Article::nexForSharingToTelegram()) {
            $notifiable->notify(new PostArticleToTelegramNotification($article));
        }
    }
}
