<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Models\Thread;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified'], ['only' => ['create']]);
    }

    public function index()
    {
        return view('forum.index', ['channel' => null]);
    }

    public function channel(Channel $channel)
    {
        return view('forum.index', compact('channel'));
    }

    public function create()
    {
        return view('forum.create');
    }

    public function show(Thread $thread)
    {
        views($thread)->record();

        return view('forum.thread', compact('thread'));
    }

    public function edit(Thread $thread)
    {
        return view('forum.edit', compact('thread'));
    }
}
