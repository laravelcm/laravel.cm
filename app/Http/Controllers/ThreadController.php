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
}
