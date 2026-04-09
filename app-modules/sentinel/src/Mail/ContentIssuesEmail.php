<?php

declare(strict_types=1);

namespace Laravelcm\Sentinel\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Laravelcm\Sentinel\Models\ContentIssue;

final class ContentIssuesEmail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    /**
     * @param  Collection<int, ContentIssue>  $issues
     */
    public function __construct(
        public readonly User $user,
        public readonly Collection $issues,
        public readonly int $deadlineDays,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('sentinel::notifications.subject', ['count' => $this->issues->count()]),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'sentinel::emails.content-issues',
        );
    }
}
