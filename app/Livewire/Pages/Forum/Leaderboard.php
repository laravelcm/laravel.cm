<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Forum;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.forum')]
final class Leaderboard extends Component
{
    public function render(): View
    {
        $startPosition = 1;
        $leaders = collect();

        /** @var Collection $leaderboard */
        $leaderboard = User::mostSolutionsInLastDays(365)
            ->take(30)
            ->get()
            ->reject(fn ($leaderboard) => $leaderboard->solutions_count === 0); // @phpstan-ignore-line

        if ($leaderboard->count() > 3) {
            $leaders = $leaderboard->slice(0, 3);
            $startPosition = 4;
        }

        return view('livewire.pages.forum.leaderboard', [
            'members' => Cache::remember(
                key: 'members',
                ttl: now()->addWeek(),
                callback: fn () => $leaderboard->reject(
                    fn (User $user) => in_array($user->id, $leaders->pluck('id')->toArray()) // @phpstan-ignore-line
                )
            ),
            'leaders' => Cache::remember(
                key: 'leaders',
                ttl: now()->addWeek(),
                callback: fn () => $leaders
            ),
            'startPosition' => $startPosition,
        ])
            ->title(__('pages/forum.navigation.leaderboard'));
    }
}
