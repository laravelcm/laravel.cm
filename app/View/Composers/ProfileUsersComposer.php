<?php

namespace App\View\Composers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ProfileUsersComposer
{
    public function compose(View $view)
    {
        $view->with('users', Cache::remember('avatar_users', now()->addDay(), function () {
            return User::verifiedUsers()->inRandomOrder()->take(10)->get();
        }));
    }
}
