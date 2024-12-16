<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Thread;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class ThreadConvertedByAdmin extends Notification
{
    use Queueable;

    public function __construct(public Thread $thread) {}

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
            ->subject(__('pages/discussion.converted_by_admin.subject'))
            ->greeting(__('pages/discussion.converted_by_admin.greeting'))
            ->line(__('pages/discussion.converted_by_admin.converted_line'))
            ->line(__('pages/discussion.converted_by_admin.thread_title').$this->thread->title)
            ->action(__('pages/discussion.converted_by_admin.action_text'), route('forum.show', $this->thread))
            ->line(__('pages/discussion.converted_by_admin.admin_action_line'));
    }
}