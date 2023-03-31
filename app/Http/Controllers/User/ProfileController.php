<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Discussion;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class ProfileController extends Controller
{
    public function show(Request $request, User $user = null): View | RedirectResponse
    {
        if ($user) {
            $articles = Article::with('tags')
                ->whereBelongsTo($user)
                ->published()
                ->recent()
                ->limit(5)
                ->get();

            $threads = Thread::whereBelongsTo($user)
                ->orderByDesc('created_at')
                ->limit(5)
                ->get();

            $discussions = Discussion::with('tags')
                ->whereBelongsTo($user)
                ->limit(5)
                ->get();

            return view('user.profile', [
                'user' => $user,
                'articles' => $articles,
                'threads' => $threads,
                'discussions' => $discussions,
                'activities' => [],
            ]);
        }

        if ($request->user()) {
            return redirect()->route('profile', $request->user()->username);
        }

        abort(404);
    }
}
