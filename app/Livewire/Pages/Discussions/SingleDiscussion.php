<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Discussions;

use App\Actions\Discussion\ConvertDiscussionToThreadAction;
use App\Actions\Discussion\DeleteDiscussionAction;
use App\Models\Discussion;
use ArchTech\SEO\SEOManager;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

final class SingleDiscussion extends Component
{
    public Discussion $discussion;

    public ?int $discussionToDelete = null;

    public bool $showConvertModal = false;

    public function mount(): void
    {
        /** @var Discussion $discussion */
        $discussion = Cache::remember(
            key: 'discussion.'.$this->discussion->id,
            ttl: now()->addDays(3),
            callback: fn (): Discussion => $this->discussion->load('user:id,name,username,avatar_type', 'tags')
        );

        views($discussion)->cooldown(now()->addHours(2))->record();

        /** @var SEOManager $seoManager */
        $seoManager = seo();

        $seoManager
            ->title($this->discussion->title)
            ->description($this->discussion->excerpt(100))
            ->image(asset('images/socialcard.png'))
            ->twitterTitle($this->discussion->title)
            ->twitterDescription($this->discussion->excerpt(100))
            ->withUrl();

        $this->discussion = $discussion;
    }

    public function edit(): void
    {
        $this->authorize('update', $this->discussion);

        $this->dispatch(
            'openPanel',
            component: 'components.slideovers.discussion-form',
            arguments: ['discussionId' => $this->discussion->id]
        );
    }

    public function confirmConvert(): void
    {
        $this->authorize('convertedToThread', $this->discussion);

        $this->showConvertModal = true;
    }

    public function convertToThread(): void
    {
        $this->authorize('convertedToThread', $this->discussion);

        $thread = resolve(ConvertDiscussionToThreadAction::class)->execute($this->discussion);

        Flux::toast(
            text: __('notifications.discussion.converted'),
            variant: 'success'
        );

        $this->showConvertModal = false;

        $this->redirectRoute('forum.show', $thread, navigate: true);
    }

    public function confirmDelete(): void
    {
        $this->authorize('delete', $this->discussion);

        $this->discussionToDelete = $this->discussion->id;

        Flux::modal('confirm-delete-discussion')->show();
    }

    public function delete(): void
    {
        if (! $this->discussionToDelete) {
            return;
        }

        $this->authorize('delete', $this->discussion);

        resolve(DeleteDiscussionAction::class)->execute($this->discussion);

        Flux::toast(
            text: __('notifications.discussion.deleted'),
            variant: 'success'
        );

        $this->discussionToDelete = null;

        Flux::modal('confirm-delete-discussion')->close();

        $this->redirectRoute('discussions.index', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.pages.discussions.single-discussion')
            ->title($this->discussion->title);
    }
}
