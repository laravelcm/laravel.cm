<?php

declare(strict_types=1);

namespace Laravelcm\Sentinel\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;
use Laravelcm\Sentinel\Models\ContentIssue;

final class ContentIssuesDetectedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly Collection $issues,
        private readonly int $deadlineDays,
    ) {}

    /** @return array<int, string> */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(User $notifiable): MailMessage
    {
        $count = $this->issues->count();

        $message = (new MailMessage)
            ->subject(__('sentinel::notifications.subject', ['count' => $count]))
            ->greeting(__('sentinel::notifications.greeting', ['name' => $notifiable->name]))
            ->line(__('sentinel::notifications.intro', ['count' => $count]))
            ->line(__('sentinel::notifications.deadline', ['days' => $this->deadlineDays]));

        /** @var ContentIssue $issue */
        foreach ($this->issues as $issue) {
            $modelName = class_basename($issue->issueable_type);
            $model = $issue->issueable;
            $title = data_get($model, 'title', data_get($model, 'subject', '#'.$issue->issueable_id));

            $message->line(__('sentinel::notifications.issue_line', [ // @phpstan-ignore argument.type
                'model' => $modelName,
                'title' => $title,
                'type' => __('sentinel::notifications.types.'.$issue->type->value),
            ]));
        }

        $message->line(__('sentinel::notifications.action'));

        return $message;
    }
}
