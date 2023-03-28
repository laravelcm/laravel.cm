<?php

declare(strict_types=1);

namespace App\Http\Livewire\Discussions;

use App\Models\Discussion;
use App\Models\Tag;
use App\Traits\WithTagsAssociation;
use Livewire\Component;

class Edit extends Component
{
    use WithTagsAssociation;

    public Discussion $discussion;

    public string $title = '';

    public string $body = '';

    protected $listeners = ['markdown-x:update' => 'onMarkdownUpdate'];

    protected $rules = [
        'title' => ['required', 'max:150'],
        'body' => ['required'],
        'tags_selected' => 'nullable|array',
    ];

    public function mount(Discussion $discussion)
    {
        $this->discussion = $discussion;
        $this->title = $discussion->title;
        $this->body = $discussion->body;
        $this->associateTags = $this->tags_selected = old('tags', $discussion->tags()->pluck('id')->toArray());
    }

    public function onMarkdownUpdate(string $content)
    {
        $this->body = $content;
    }

    public function store()
    {
        $this->validate();

        $this->discussion->update([
            'title' => $this->title,
            'slug' => $this->title,
            'body' => $this->body,
        ]);

        if (collect($this->associateTags)->isNotEmpty()) {
            $this->discussion->syncTags($this->associateTags);
        }

        $this->redirectRoute('discussions.show', $this->discussion);
    }

    public function render()
    {
        return view('livewire.discussions.edit', [
            'tags' => Tag::whereJsonContains('concerns', ['discussion'])->get(),
        ]);
    }
}
