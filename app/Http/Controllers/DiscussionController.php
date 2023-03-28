<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Policies\DiscussionPolicy;

class DiscussionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified'], ['except' => ['index', 'show']]);
    }

    public function index()
    {
        return view('discussions.index');
    }

    public function show(Discussion $discussion)
    {
        views($discussion)->record();

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

    public function create()
    {
        return view('discussions.new');
    }

    public function edit(Discussion $discussion)
    {
        $this->authorize(DiscussionPolicy::UPDATE, $discussion);

        return view('discussions.edit', compact('discussion'));
    }
}
