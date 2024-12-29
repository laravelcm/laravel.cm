<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class SendEMailToDeletedUser extends Notification implements ShouldQueue
{
    use Queueable;

    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->subject(__('Suppression de compte | Laravel DRC'))
            ->line(__('Pour des raisons de validité et d\'authenticité de votre adresse email'))
            ->line(__('Nous avons supprimé votre compte après 10 jours d\'inscription sans validation de votre adresse email.'))
            ->line(__('Nous ne pouvons donc pas authentifier que cette adresse e-mail est belle et bien utilisée.'))
            ->line(__('Merci d\'avoir utilisé Laravel DRC!'));
    }
}
