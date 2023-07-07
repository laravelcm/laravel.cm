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

    public function index(): View
    {
        return view('discussions.index');
    }

    public function show(Discussion $discussion): View
    {
        views($discussion)->record();

        // @phpstan-ignore-next-line
        seo()
            ->title($discussion->title)
            ->description($discussion->excerpt(100))
            ->image(asset('images/socialcard.png'))
            ->twitterTitle($discussion->title)
            ->twitterDescription($discussion->excerpt(100))
            ->twitterImage(asset('images/socialcard.png'))
            ->twitterSite('laravelcm')
            ->withUrl();

        return view('discussions.show', ['discussion' => $discussion->load('tags')]);
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
