<?php

declare(strict_types=1);

namespace App\Http\Livewire\Forum;

use App\Events\ThreadWasCreated;
use App\Gamify\Points\ThreadCreated;
use App\Models\Channel;
use App\Models\Thread;
use App\Traits\WithChannelsAssociation;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Ramsey\Uuid\Uuid;

final class CreateThread extends Component
{
    use WithChannelsAssociation;

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

    public function onMarkdownUpdate(string $content): void
    {
        $this->body = $content;
    }

    public function store(): void
    {
        $this->validate();
        $author = Auth::user();

        $thread = Thread::create([
            'title' => $this->title,
            'body' => $this->body,
            'slug' => $this->title,
            'user_id' => $author->id, // @phpstan-ignore-line
        ]);

        $thread->syncChannels($this->associateChannels);

        // Subscribe author to the thread.
        $subscription = new \App\Models\Subscribe();
        $subscription->uuid = Uuid::uuid4()->toString();
        $subscription->user()->associate($author);
        $subscription->subscribeAble()->associate($thread);

        $thread->subscribes()->save($subscription);

        givePoint(new ThreadCreated($thread));

        if (app()->environment('production')) {
            event(new ThreadWasCreated($thread));
        }

        $this->redirectRoute('forum.show', $thread);
    }

    public function render(): View
    {
        return view('livewire.forum.create-thread', [
            'channels' => Channel::all(),
        ]);
    }
}
