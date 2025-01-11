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
        $discussions = Cache::remember(
            key: 'inactive_discussions',
            ttl: now()->addWeek(),
            callback: fn () => Discussion::with('user', 'user.media')->noComments()->limit(5)->get()
        );

        $view->with('discussions', $discussions);
    }
}
