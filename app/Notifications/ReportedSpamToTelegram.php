<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\SpamReport;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

final class ReportedSpamToTelegram extends Notification
{
    use Queueable;

    public function __construct(public SpamReport $spamReport) {}

    public function via(object $notifiable): array
    {
        return [TelegramChannel::class];
    }

    public function toTelegram(): TelegramMessage
    {
        return TelegramMessage::create()
            ->to('@laravelcd')
            ->content("{$this->spamReport->user?->name} vient de reporter un contenu spam")
            ->button('Voir les spams', route('filament.admin.pages.dashboard'));
    }
}
