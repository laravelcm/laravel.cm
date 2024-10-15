<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ArticleWasSubmittedForApproval;
use App\Notifications\ArticleSubmitted;
use Illuminate\Notifications\AnonymousNotifiable;

final readonly class SendNewArticleNotification
{
    public function __construct(private AnonymousNotifiable $notifiable)
    {
    }

    public function handle(ArticleWasSubmittedForApproval $event): void
    {
        $this->notifiable->notify(new ArticleSubmitted($event->article));
    }
}
