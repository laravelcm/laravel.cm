<?php

declare(strict_types=1);

namespace App\View\Composers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

final class ModeratorsComposer
{
    public function compose(View $view): void
    {
        $view->with(
            'moderators',
            Cache::remember(
                key: 'moderators',
                ttl: now()->addMonths(6),
                callback: fn () => User::query()->scopes('moderators')->get()
            )
        );
    }
}
