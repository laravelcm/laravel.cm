<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Policies\DiscussionPolicy;
use Illuminate\Contracts\View\View;

final class DiscussionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified'], ['except' => ['index', 'show']]);
    }

    public function create(): View
    {
        return view('discussions.new');
    }

    public function edit(Discussion $discussion): View
    {
        $this->authorize(DiscussionPolicy::UPDATE, $discussion);

        return view('discussions.edit', compact('discussion'));
    }
}
