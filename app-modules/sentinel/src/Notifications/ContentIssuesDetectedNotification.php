<?php

declare(strict_types=1);

namespace Laravelcm\Sentinel\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;
use Laravelcm\Sentinel\Mail\ContentIssuesEmail;
use Laravelcm\Sentinel\Models\ContentIssue;

final class ContentIssuesDetectedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @param  Collection<int, ContentIssue>  $issues
     */
    public function __construct(
        private readonly Collection $issues,
        private readonly int $deadlineDays,
    ) {}

    /** @return array<int, string> */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(User $notifiable): ContentIssuesEmail
    {
        return new ContentIssuesEmail($notifiable, $this->issues, $this->deadlineDays)
            ->to($notifiable->email, $notifiable->name);
    }
}
