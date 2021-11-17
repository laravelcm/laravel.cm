<?php

namespace App\View\Composers;

use App\Models\Discussion;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class InactiveDiscussionsComposer
{
    public function compose(View $view)
    {
        $discussions = Cache::remember('inactive-discussions', 60 * 60 * 24, function () {
            return Discussion::noComments()->limit(5)->get();
        });

        $view->with('discussions', $discussions);
    }
}
