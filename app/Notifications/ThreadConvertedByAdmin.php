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
            ->subject('pages/discussion.converted_by_admin')
            ->greeting('Hello!')
            ->line('An admin has converted a discussion to a thread.')
            ->line('Thread Title: '.$this->thread->title)
            ->action('View Thread', route('forum.show', $this->thread))
            ->line('This action was performed by an administrator.');
    }
}
