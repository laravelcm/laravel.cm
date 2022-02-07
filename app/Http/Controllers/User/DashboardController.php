<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('user.dashboard', [
            'user' => $user = User::scopes('withCounts')->find(Auth::id()),
            'articles' => $user->articles()
                ->orderByDesc('created_at')
                ->orderBy('submitted_at')
                ->paginate(5),
        ]);
    }

    public function threads()
    {
        return view('user.threads', [
            'user' => $user = User::scopes('withCounts')->find(Auth::id()),
            'threads' => $user->threads()
                ->recent()
                ->paginate(5),
        ]);
    }

    public function discussions()
    {
        return view('user.discussions', [
            'user' => $user = User::scopes('withCounts')->find(Auth::id()),
            'discussions' => $user->discussions()
                ->orderByDesc('created_at')
                ->paginate(5),
        ]);
    }
}
