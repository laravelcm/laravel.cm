<?php

namespace App\View\Composers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class TopMembersComposer
{
    public function compose(View $view): void
    {
        $view->with('topMembers', Cache::remember('topMembers', now()->addMinutes(30), function () {
            return User::mostSolutionsInLastDays(365)->take(5)->get();
        }));
    }
}
