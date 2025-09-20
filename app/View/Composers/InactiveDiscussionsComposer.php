<?php

declare(strict_types=1);

namespace App\View\Composers;

use App\Models\Discussion;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

final class InactiveDiscussionsComposer
{
    public function compose(View $view): void
    {
        $discussions = Cache::remember(
            key: 'discussions.inactive',
            ttl: now()->addWeek(),
            callback: fn (): Collection => Discussion::with([
                'user:id,username,name,avatar_type',
                'user.media',
            ])
                ->noComments()
                ->limit(5)
                ->get()
        );

        $view->with('discussions', $discussions);
    }
}
