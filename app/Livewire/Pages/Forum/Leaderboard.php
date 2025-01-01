<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Forum;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.forum')]
final class Leaderboard extends Component
{
    public function render(): View
    {
        return view('livewire.pages.forum.leaderboard', [
            'leaderboard' => Cache::remember(
                key: 'leaderboard',
                ttl: now()->addWeek(),
                callback: fn () => User::mostSolutionsInLastDays(365)
                    ->take(30)
                    ->get()
                    ->reject(fn ($leaderboard) => $leaderboard->solutions_count === 0) // @phpstan-ignore-line
            ),
        ]);
    }
}
