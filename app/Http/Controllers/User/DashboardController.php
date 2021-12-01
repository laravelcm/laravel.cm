<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('user.dashboard', [
            'user' => $user = Auth::user(),
            'articles' => $user->articles()
                ->orderByDesc('submitted_at')
                ->orderByDesc('created_at')
                ->paginate(5),
        ]);
    }

    public function threads()
    {
        return view('user.threads', [
            'user' => $user = Auth::user(),
            'threads' => $user->threads()
                ->recent()
                ->paginate(5),
        ]);
    }

    public function discussions()
    {
        return view('user.discussions', [
            'user' => $user = Auth::user(),
            'discussions' => $user->discussions()
                ->orderByDesc('created_at')
                ->paginate(5),
        ]);
    }
}
