<?php

namespace App\View\Composers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

final class ProfileUsersComposer
{
    public function compose(View $view): void
    {
        $view->with('users', Cache::remember('avatar_users', now()->addWeek(), function () {
            return User::verifiedUsers()->inRandomOrder()->take(10)->get();
        }));
    }
}
