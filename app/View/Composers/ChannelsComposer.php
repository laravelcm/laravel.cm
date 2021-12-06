<?php

namespace App\View\Composers;

use App\Models\Channel;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ChannelsComposer
{
    public function compose(View $view)
    {
        $view->with(
            'channels',
            Cache::remember(
                'channels',
                now()->addDay(),
                fn () => Channel::with('items')->whereNull('parent_id')->get()
            )
        );
    }
}
