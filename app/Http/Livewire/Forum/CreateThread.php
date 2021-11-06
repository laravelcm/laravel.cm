<?php

namespace App\Http\Livewire\Forum;

use App\Models\Channel;
use App\Models\Thread;
use App\Traits\WithChannelsAssociation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateThread extends Component
{
    use WithChannelsAssociation;

    public string $title = '';
    public string $body = '';

    protected $listeners = ['markdown-x:update' => 'onMarkdownUpdate'];

    protected $rules = [
        'title' => 'required|max:75',
        'body' => 'required',
    ];

    public function onMarkdownUpdate(string $content)
    {
        $this->body = $content;
    }

    public function store()
    {
        $this->validate();

        $thread = Thread::create([
            'title' => $this->title,
            'body' => $this->body,
            'slug' => $this->title,
            'user_id' => Auth::id(),
        ]);

        $thread->syncChannels($this->associateChannels);

        $this->redirectRoute('forum.show', $thread);
    }

    public function render()
    {
        return view('livewire.forum.create-thread', [
            'channels' => Channel::all(),
        ]);
    }
}
