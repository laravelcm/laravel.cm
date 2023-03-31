<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\User;
use Illuminate\Queue\SerializesModels;

class ApiRegistered
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public User $user)
    {
    }
}
