<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;

use function Livewire\Volt\{on};
use function Livewire\Volt\{state};

state(['hasNotification' => Auth::user()->unreadNotifications()->count() > 0 ]);

on(['NotificationMarkedAsRead' => fn (int $count) => $count > 0 ]);

?>

<span
    @class([
        'shadow-solid absolute right-0 top-0 block size-2 rounded-full bg-primary-600 text-white',
        'hidden' => ! $hasNotification,
        'block' => $hasNotification,
    ])
></span>
