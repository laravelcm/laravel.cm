<?php

declare(strict_types=1);

namespace App\Http\Livewire\Forum;

use App\Models\Channel;
use App\Models\Thread;
use App\Traits\WithChannelsAssociation;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class EditThread extends Component
{
    use WithChannelsAssociation;

    public Thread $thread;

    public string $title = '';

    public string $body = '';

    /**
     * @var string[]
     */
    protected $listeners = ['markdown-x:update' => 'onMarkdownUpdate'];

    /**
     * @var string[]
     */
    protected $rules = [
        'title' => 'required|max:75',
        'body' => 'required',
    ];

    public function mount(Thread $thread): void
    {
        $this->title = $thread->title;
        $this->body = $thread->body;
        $this->associateChannels = $this->channels_selected = old('channels', $thread->channels()->pluck('id')->toArray());
    }

    public function onMarkdownUpdate(string $content): void
    {
        $this->body = $content;
    }

    public function store(): void
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

    public function render(): View
    {
        return view('livewire.forum.edit-thread', [
            'channels' => Channel::all(),
        ]);
    }
}
