<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\SponsoringPaymentInitialize;
use App\Notifications\NewSponsorPaymentNotification;
use Illuminate\Notifications\AnonymousNotifiable;

final readonly class SendPaymentNotification
{
    public function __construct(private AnonymousNotifiable $notifiable)
    {
    }

    public function handle(SponsoringPaymentInitialize $event): void
    {
        $this->notifiable->notify(new NewSponsorPaymentNotification($event->transaction));
    }
}
