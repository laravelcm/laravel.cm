<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class UserBannedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public User $user) {}
}
