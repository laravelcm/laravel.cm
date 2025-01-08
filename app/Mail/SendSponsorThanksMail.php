<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

final class SendSponsorThanksMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $name) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('emails/sponsor.subject'),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.send-sponsor-thanks-mail',
            with: [
                'name' => $this->name,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
