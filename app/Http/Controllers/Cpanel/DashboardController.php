<?php

declare(strict_types=1);

namespace App\Http\Controllers\Cpanel;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

final class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $users = Cache::remember('new-members', now()->addHour(), fn () => User::verifiedUsers()->latest()->limit(15)->get());
        $latestArticles = Cache::remember('last-posts', now()->addHour(), fn () => Article::latest()->limit(2)->get());

        return view('cpanel.dashboard', [
            'latestArticles' => $latestArticles,
            'users' => $users,
        ]);
    }
}
