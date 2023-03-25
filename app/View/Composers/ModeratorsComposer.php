<?php

namespace App\View\Composers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

final class ModeratorsComposer
{
    public function compose(View $view): void
    {
        $view->with('moderators', Cache::remember('moderators', now()->addYear(), function () {
            return User::moderators()->get();
        }));
    }
}
