<?php

declare(strict_types=1);

namespace App\View\Composers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

final class TopContributorsComposer
{
    public function compose(View $view): void
    {
        $topContributors = Cache::remember(
            key: 'contributors',
            ttl: now()->addWeek(),
            callback: fn () => User::with('media')
                ->select('id', 'username', 'name', 'avatar_type')
                ->scopes('topContributors')
                ->limit(5)
                ->get()
                ->filter(fn (User $contributor): bool => $contributor->discussions_count >= 1)
        );

        $view->with('topContributors', $topContributors);
    }
}
