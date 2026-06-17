<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Article;
use App\Notifications\PendingArticlesNotification;
use Illuminate\Console\Command;
use Illuminate\Notifications\AnonymousNotifiable;

#[\Illuminate\Console\Attributes\Description('Send a Telegram notification for articles that are submitted but neither approved nor declined')]
#[\Illuminate\Console\Attributes\Signature('lcm:notify-pending-articles')]
final class NotifyPendingArticles extends Command
{
    public function handle(AnonymousNotifiable $notifiable): void
    {
        $pendingArticles = Article::awaitingApproval()->get();

        if ($pendingArticles->isNotEmpty()) {
            $notifiable->notify(new PendingArticlesNotification($pendingArticles));
        }
    }
}
