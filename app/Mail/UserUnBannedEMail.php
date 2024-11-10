<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

final class UserUnBannedEMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user){}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('Notification de dé-baannissement Laravelcm'),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.send-user-unbanned-message',
        );
    }
}