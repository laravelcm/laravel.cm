<?php

declare(strict_types=1);

namespace App\View\Composers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

final class TopMembersComposer
{
    public function compose(View $view): void
    {
        $view->with('topMembers', Cache::remember('topMembers', now()->addWeek(), fn () => User::mostSolutionsInLastDays(365)->take(5)->get()));
    }
}
