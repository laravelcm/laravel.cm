<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;

class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified'], ['except' => ['index', 'show']]);
    }

    public function index()
    {
        return view('articles.index');
    }

    public function show(Article $article)
    {
        $user = Auth::user();

        abort_unless(
            $article->isPublished() || ($user && $user->hasAnyRole(['admin', 'moderator'])),
            404
        );

        return view('articles.show', compact('article'));
    }

    public function create()
    {
        return view('articles.new');
    }
}
