<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

final class NewSponsorPaymentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly Transaction $transaction) {}

    public function via(mixed $notifiable): array
    {
        if (
            ! empty(config('services.telegram-bot-api.token')) &&
            ! empty(config('services.telegram-bot-api.channel'))
        ) {
            return [TelegramChannel::class];
        }

        return [];
    }

    public function toTelegram(): TelegramMessage
    {
        return TelegramMessage::create()
            ->to(config('services.telegram-bot-api.channel'))
            ->content($this->content())
            ->button('Voir les sponsors', route('sponsors'));
    }

    private function content(): string
    {
        $content = "*Nouveau paiement de Sponsoring enregistré!*\n\n";
        $content .= 'Auteur: '.$this->transaction->getMetadata('merchant')['name']."\n";
        $content .= 'Montant: '.$this->transaction->amount;

        if ($this->transaction->getMetadata('merchant')['laravel_cm_id']) {
            $content .= 'Profil Laravel DRC: [@'.$this->transaction->user?->username.']('.route('profile', $this->transaction->user?->username).')';
        }

        return $content;
    }
}
