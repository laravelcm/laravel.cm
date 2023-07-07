<?php

declare(strict_types=1);

namespace App\Http\Livewire\Discussions;

use App\Models\Discussion;
use App\Models\Reply;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

final class Comments extends Component
{
    public Discussion $discussion;

    /**
     * @var string[]
     */
    public $listeners = ['reloadComments' => '$refresh'];

    public function mount(Discussion $discussion): void
    {
        $this->discussion = $discussion;
    }

    public function getCommentsProperty(): Collection
    {
        $replies = collect();

        foreach ($this->discussion->replies->load(['allChildReplies', 'user']) as $reply) {
            /** @var Reply $reply */
            if ($reply->allChildReplies->isNotEmpty()) {
                foreach ($reply->allChildReplies as $childReply) {
                    $replies->add($childReply);
                }
            }

            $replies->add($reply);
        }

        return $replies;
    }

    public function render(): View
    {
        return view('livewire.discussions.comments');
    }
}
