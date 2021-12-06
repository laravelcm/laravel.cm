<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified'], ['only' => ['create', 'edit']]);
    }

    public function index(Request $request)
    {
        $filter = getFilter('sortBy', ['recent', 'resolved', 'unresolved']);
        $threads = Thread::filter($request)->withviewscount()->paginate(10);

        return view('forum.index', [
            'channel' => null,
            'threads' => $threads,
            'filter' => $filter,
        ]);
    }

    public function channel(Request $request, Channel $channel)
    {
        $filter = getFilter('sortBy', ['recent', 'resolved', 'unresolved']);
        $threads = Thread::forChannel($channel)->filter($request)->withviewscount()->paginate(10);

        return view('forum.index', compact('channel', 'threads', 'filter'));
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
