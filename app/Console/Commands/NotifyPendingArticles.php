<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;
use Illuminate\Notifications\AnonymousNotifiable;
use App\Notifications\PendingArticlesNotification;

final class NotifyPendingArticles extends Command
{
    protected $signature = 'lcm:notify-pending-articles';

    protected $description = 'Send a Telegram notification for articles that are submitted but neither approved nor declined';

    public function handle(AnonymousNotifiable $notifiable): void
    {
        $pendingArticles = Article::awaitingApproval()->get();

        if ($pendingArticles->isNotEmpty()) {
            $notifiable->notify(new PendingArticlesNotification($pendingArticles));
        }
    }
}
