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
            'articles' => $user->articles()->latest()->paginate(10),
        ]);
    }

    public function threads()
    {
        return view('user.threads', [
            'user' => $user = Auth::user(),
        ]);
    }

    public function discussions()
    {
        return view('user.discussions', [
            'user' => $user = Auth::user(),
        ]);
    }
}
