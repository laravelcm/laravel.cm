<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request, User $user = null)
    {
        if ($user) {
            $articles = $user->articles;

            return view('user.profile', compact('user', 'articles'));
        }

        if ($request->user()) {
            return redirect()->route('profile', $request->user()->username);
        }

        abort(404);
    }
}
