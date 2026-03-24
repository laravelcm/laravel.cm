<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\User;
use App\Notifications\UserUnBannedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

final class SendUnbanEmailJob implements ShouldQueue
{
    use \Illuminate\Foundation\Queue\Queueable;

    public function __construct(public User $user) {}

    public function handle(): void
    {
        $this->user->notify(new UserUnBannedNotification($this->user));
    }
}
