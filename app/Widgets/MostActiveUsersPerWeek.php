<?php

declare(strict_types=1);

namespace App\Widgets;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

final class MostActiveUsersPerWeek
{
    /**
     * The configuration array.
     *
     * @var array<string>
     */
    protected array $config = [];

    /**
     * The number of seconds before each reload.
     */
    public int|float $reloadTimeout = 60 * 60 * 24 * 2; // 2 days

    /**
     * The number of minutes before cache expires.
     * False means no caching at all.
     */
    public int|float|bool $cacheTime = 0;

    public function run(): View
    {
        $users = User::with('activities')
            ->withCount('activities')
            ->verifiedUsers()
            ->whereHas('activities', fn (Builder $query) => $query->whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ]))
            ->orderByDesc('activities_count')
            ->limit(5)
            ->get();

        return view('widgets.most_active_users_per_week', [
            'config' => $this->config,
            'users' => $users,
        ]);
    }
}
