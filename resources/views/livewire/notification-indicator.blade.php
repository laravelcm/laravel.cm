<?php

declare(strict_types=1);

use function Livewire\Volt\{on};
use Illuminate\Support\Facades\Auth;

use function Livewire\Volt\{state};

state(['hasNotification' => Auth::user()->unreadNotifications()->count() > 0 ]);

on(['NotificationMarkedAsRead' => function (int $count) {
    return $count > 0 ;
}]);

?>

<span
    @class([
        'hidden' => !$hasNotification,
        'shadow-solid absolute right-0 top-0 block size-2 rounded-full bg-primary-600 text-white' => $hasNotification
    ])
></span>
