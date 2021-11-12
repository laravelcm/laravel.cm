<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProfileController extends Controller
{
    public function show(Request $request, User $user = null)
    {
        if ($user) {
            return view('user.profile', [
                'user' => Cache::remember('user-profile', now()->addMinutes(30), fn () => $user),
            ]);
        }

        if ($request->user()) {
            return redirect()->route('profile', $request->user()->username);
        }

        abort(404);
    }
}
