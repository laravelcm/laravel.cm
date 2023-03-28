<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twitter\TwitterChannel;
use NotificationChannels\Twitter\TwitterStatusUpdate;

class PostArticleToTwitter extends Notification
{
    use Queueable;

    public function __construct(public Article $article)
    {
    }

    public function via($notifiable): array
    {
        return [TwitterChannel::class];
    }

    public function toTwitter($notifiable)
    {
        return new TwitterStatusUpdate($this->generateTweet());
    }

    public function generateTweet(): string
    {
        $title = $this->article->title;
        $url = route('articles.show', $this->article->slug());
        $author = $this->article->author;
        $author = $author->twitter() ? "@{$author->twitter()}" : $author->name;

        return "{$title} par {$author}\n\n{$url}";
    }
}
