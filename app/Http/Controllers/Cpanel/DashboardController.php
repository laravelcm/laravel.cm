<?php

namespace App\Http\Controllers\Cpanel;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function home()
    {
        $users = Cache::remember('new-members', now()->addHour(), fn () => User::verifiedUsers()->latest()->limit(10)->get());
        $latestArticles = Cache::remember('last-posts', now()->addHour(), fn () => Article::latest()->limit(2)->get());

        return view('cpanel.dashboard', [
           'latestArticles' => $latestArticles,
            'users' => $users,
        ]);
    }
}
