<?php

declare(strict_types=1);

namespace App\View\Composers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

final class ProfileUsersComposer
{
    public function compose(View $view): void
    {
        $view->with(
            'users',
            Cache::remember(
                key: 'avatar_users',
                ttl: now()->addWeek(),
                callback: fn () => User::verifiedUsers()->inRandomOrder()->take(10)->get()
            )
        );
    }
}
