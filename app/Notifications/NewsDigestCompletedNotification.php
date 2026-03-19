<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

final class NewsDigestCompletedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly int $articleCount,
        private readonly string $provider,
        private readonly string $model,
    ) {}

    /**
     * @return list<class-string>
     */
    public function via(mixed $notifiable): array
    {
        if (
            filled(config('services.telegram-bot-api.token')) &&
            filled(config('services.telegram-bot-api.channel'))
        ) {
            return [TelegramChannel::class];
        }

        return [];
    }

    public function toTelegram(): TelegramMessage
    {
        /** @var string $telegramChannel */
        $telegramChannel = config('services.telegram-bot-api.channel');

        $content = "*🤖 Digest IA genere*\n\n";
        $content .= $this->articleCount.' article(s) soumis pour validation.
';
        $content .= sprintf('Provider: %s%s', $this->provider, PHP_EOL);
        $content .= 'Model: '.$this->model;

        return TelegramMessage::create()
            ->to($telegramChannel)
            ->content($content)
            ->button('Voir les articles en attente', route('filament.cpanel.resources.articles.index'));
    }
}
