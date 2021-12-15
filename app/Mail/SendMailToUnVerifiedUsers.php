<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailToUnVerifiedUsers extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user)
    {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Vérification Email')
            ->markdown('emails.send-mail-to-un-verified-users');
    }
}
