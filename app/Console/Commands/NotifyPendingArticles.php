<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Article;
use App\Notifications\PendingArticlesNotification;
use Illuminate\Console\Command;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;

final class NotifyPendingArticles extends Command
{
    protected $signature = 'lcm:notify-pending-articles';

    protected $description = 'Send a Telegram notification for articles that are submitted but neither approved nor declined';

    public function handle(AnonymousNotifiable $notifiable): void
    {
        // Récupérer les articles soumis mais non approuvés ni déclinés via le scope  awaitingApproval
        $pendingArticles = Article::awaitingApproval()->get();

        if ($pendingArticles->isEmpty()) {
            $this->info('❌ No pending articles found.');
            return;
        }

        //Envoi de la notification via télégram
        $notifiable->notify(new PendingArticlesNotification($pendingArticles));
        $this->info('✅ Notification sent successfully.');
    }
}