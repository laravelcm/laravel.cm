<?php

namespace App\View\Composers;

use App\Models\Channel;
use Illuminate\View\View;

class ChannelsComposer
{
    public function compose(View $view)
    {
        $view->with(
            'channels',
            Channel::with('items')
            ->whereNull('parent_id')
            ->get()
        );
    }
}
