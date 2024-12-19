<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;

use function Livewire\Volt\{on};
use function Livewire\Volt\{state};

state(['count' => Auth::user()->unreadNotifications()->count()]);

on(['NotificationMarkedAsRead' => fn (int $count) => $count ]);

?>

<span class="rounded-full bg-green-100 px-3 text-base text-green-500">
    {{ $count }}
</span>
