<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel(
    channel: 'App.Models.User.{id}',
    callback: fn (User $user, int $id) => $user->id === $id
);
