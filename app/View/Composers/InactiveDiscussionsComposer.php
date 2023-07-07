<?php

declare(strict_types=1);

namespace App\View\Composers;

use App\Models\Discussion;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

final class InactiveDiscussionsComposer
{
    public function compose(View $view): void
    {
        $discussions = Cache::remember('inactive_discussions', now()->addDays(3), fn () => Discussion::noComments()->limit(5)->get());

        $view->with('discussions', $discussions);
    }
}
