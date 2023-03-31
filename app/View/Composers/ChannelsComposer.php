<?php

declare(strict_types=1);

namespace App\View\Composers;

use App\Models\Channel;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

final class ChannelsComposer
{
    public function compose(View $view): void
    {
        $view->with(
            'channels',
            Cache::remember(
                'channels',
                now()->addWeek(),
                fn () => Channel::with('items')->whereNull('parent_id')->get()
            )
        );
    }
}
