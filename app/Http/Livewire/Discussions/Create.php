<?php

declare(strict_types=1);

namespace App\Http\Livewire\Discussions;

use App\Gamify\Points\DiscussionCreated;
use App\Models\Discussion;
use App\Models\Tag;
use App\Notifications\PostDiscussionToTelegram;
use App\Traits\WithTagsAssociation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
    use WithTagsAssociation;

    public string $title = '';

    public string $body = '';

    protected $listeners = ['markdown-x:update' => 'onMarkdownUpdate'];

    protected $rules = [
        'title' => ['required', 'max:150'],
        'body' => ['required'],
        'tags_selected' => 'nullable|array',
    ];

    public function onMarkdownUpdate(string $content)
    {
        $this->body = $content;
    }

    public function store()
    {
        $this->validate();

        $discussion = Discussion::create([
            'title' => $this->title,
            'slug' => $this->title,
            'body' => $this->body,
            'user_id' => Auth::id(),
        ]);

        if (collect($this->associateTags)->isNotEmpty()) {
            $discussion->syncTags($this->associateTags);
        }

        givePoint(new DiscussionCreated($discussion));

        if (app()->environment('production')) {
            Auth::user()->notify(new PostDiscussionToTelegram($discussion));
        }

        $this->redirectRoute('discussions.show', $discussion);
    }

    public function render()
    {
        return view('livewire.discussions.create', [
            'tags' => Tag::whereJsonContains('concerns', ['discussion'])->get(),
        ]);
    }
}
