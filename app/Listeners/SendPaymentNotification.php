<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\SponsoringPaymentInitialize;
use App\Mail\SendSponsorThanksMail;
use App\Notifications\NewSponsorPaymentNotification;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Mail;

final readonly class SendPaymentNotification
{
    public function __construct(private AnonymousNotifiable $notifiable) {}

    public function handle(SponsoringPaymentInitialize $event): void
    {
        /**
         * @var array $merchant
         *            - 'email' (string)
         *            - 'name' (string)
         */
        $merchant = $event->transaction->getMetadata('merchant');

        $this->notifiable->notify(new NewSponsorPaymentNotification($event->transaction));

        Mail::to($merchant['email'])
            ->send(new SendSponsorThanksMail($merchant['name']));
    }
}
