<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

final class DashboardController extends Controller
{
    public function dashboard(): View
    {
        return view('user.dashboard', [
            'user' => $user = User::scopes('withCounts')->find(Auth::id()),
            'articles' => $user->articles()
                ->orderByDesc('created_at')
                ->orderBy('submitted_at')
                ->paginate(5),
        ]);
    }

    public function threads(): View
    {
        return view('user.threads', [
            'user' => $user = User::scopes('withCounts')->find(Auth::id()),
            'threads' => $user->threads()
                ->recent()
                ->paginate(5),
        ]);
    }

    public function discussions(): View
    {
        return view('user.discussions', [
            'user' => $user = User::scopes('withCounts')->find(Auth::id()),
            'discussions' => $user->discussions()
                ->orderByDesc('created_at')
                ->paginate(5),
        ]);
    }
}
