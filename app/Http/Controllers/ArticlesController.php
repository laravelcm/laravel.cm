<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Article;
use App\Models\Tag;

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
    }

    public function create()
    {
        return view('articles.new', [
            'tags' => Tag::whereJsonContains('concerns', ['post'])->pluck('name', 'id'),
        ]);
    }

    public function store(CreatePostRequest $request)
    {
        dd($request->all());
    }
}
