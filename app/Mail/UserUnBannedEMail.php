<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

final class UserUnBannedEMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public User $user) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('user.unbanned.email_subject'),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.send-unbanned-message',
        );
    }
}
