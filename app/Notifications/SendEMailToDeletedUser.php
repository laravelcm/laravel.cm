<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendEMailToDeletedUser extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Suppression de compte | Laravel Cameroun')
                    ->line('Pour des raisons de validité et d\'authenticité de votre adresse email')
                    ->line('Nous avons supprimé votre compte après 10 jours d\'inscription sans validation de votre adresse email.')
                    ->line('Nous ne pouvons donc pas authentifier que cette adresse email est belle et bien utilisée.')
                    ->line('Merci d\'avoir utilise Laravel Cameroun!');
    }
}
