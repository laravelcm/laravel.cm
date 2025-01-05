<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Thread;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class ThreadConvertedByCreator extends Notification
{
    use Queueable;

    public function __construct(protected Thread $thread) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('pages/discussion.converted_by_creator.subject'))
            ->line(__('pages/discussion.converted_by_creator.converted_line'))
            ->line(__('pages/discussion.converted_by_creator.thread_title').$this->thread->title)
            ->action(__('pages/discussion.converted_by_creator.action_text'), route('forum.show', $this->thread))
            ->line(__('pages/discussion.converted_by_creator.thank_you_line'));
    }
}
