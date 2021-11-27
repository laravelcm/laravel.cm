<?php

namespace App\View\Composers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class TopContributorsComposer
{
    public function compose(View $view)
    {
        $topContributors = Cache::remember('contributors', 60 * 30, function () {
            return User::topContributors()
                ->get()
                ->filter(fn ($contributor) => $contributor->discussions_count >= 1)
                ->take(5);
        });

        $view->with('topContributors', $topContributors);
    }
}
