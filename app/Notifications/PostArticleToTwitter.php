<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twitter\Exceptions\CouldNotSendNotification;
use NotificationChannels\Twitter\TwitterChannel;
use NotificationChannels\Twitter\TwitterStatusUpdate;

final class PostArticleToTwitter extends Notification
{
    use Queueable;

    public readonly Article $article;

    public function __construct(Article $article)
    {
        $this->article = $article->load('user');
    }

    public function via(mixed $notifiable): array
    {
        return [TwitterChannel::class];
    }

    /**
     * @throws CouldNotSendNotification
     */
    public function toTwitter(): TwitterStatusUpdate
    {
        return new TwitterStatusUpdate($this->generateTweet());
    }

    public function generateTweet(): string
    {
        $title = $this->article->title;
        $url = route('articles.show', $this->article->slug());
        $author = $this->article->user;
        $author = $author->twitter() ? "@{$author->twitter()}" : $author->name;

        return "{$title} par {$author}\n\n{$url}\n\n #CaParleDev";
    }
}
