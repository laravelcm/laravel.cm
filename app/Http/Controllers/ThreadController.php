<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Thread;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified'], ['only' => ['create', 'edit']]);
    }

    public function index(Request $request): View
    {
        $filter = getFilter('sortBy', ['recent', 'resolved', 'unresolved']);
        $threads = Thread::filter($request)
            ->withviewscount()
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('forum.index', [
            'channel' => null,
            'threads' => $threads,
            'filter' => $filter,
        ]);
    }

    public function channel(Request $request, Channel $channel): View
    {
        $filter = getFilter('sortBy', ['recent', 'resolved', 'unresolved']);
        $threads = Thread::forChannel($channel)
            ->filter($request)
            ->withviewscount()
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('forum.index', compact('channel', 'threads', 'filter'));
    }

    public function create(): View
    {
        return view('forum.create');
    }

    public function show(Thread $thread): View
    {
        views($thread)->record();

        return view('forum.thread', compact('thread'));
    }

    public function edit(Thread $thread): View
    {
        return view('forum.edit', compact('thread'));
    }
}
