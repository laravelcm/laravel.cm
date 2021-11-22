<?php

namespace App\Http\Livewire\Forum;

use App\Models\Channel;
use App\Models\Thread;
use App\Traits\WithChannelsAssociation;
use Livewire\Component;

class EditThread extends Component
{
    use WithChannelsAssociation;

    public Thread $thread;
    public string $title = '';
    public string $body = '';

    protected $listeners = ['markdown-x:update' => 'onMarkdownUpdate'];

    protected $rules = [
        'title' => 'required|max:75',
        'body' => 'required',
    ];

    public function mount(Thread $thread)
    {
        $this->title = $thread->title;
        $this->body = $thread->body;
        $this->associateChannels = $this->channels_selected = old('channels', $thread->channels()->pluck('id')->toArray());
    }

    public function onMarkdownUpdate(string $content)
    {
        $this->body = $content;
    }

    public function store()
    {
        $this->validate();

        $this->thread->update([
            'title' => $this->title,
            'slug' => $this->title,
            'body' => $this->body,
        ]);

        $this->thread->syncChannels($this->associateChannels);

        $this->redirectRoute('forum.show', $this->thread);
    }

    public function render()
    {
        return view('livewire.forum.edit-thread', [
            'channels' => Channel::all(),
        ]);
    }
}
