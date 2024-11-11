<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Discussions;

use App\Models\Discussion;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class SingleDiscussion extends Component
{
    public Discussion $discussion;

    public function mount(Discussion $discussion): void
    {
        views($discussion)->cooldown(now()->addHours(2))->record();

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

        $this->discussion = $discussion->load('tags');
    }

    public function render(): View
    {
        return view('livewire.pages.discussions.single-discussion')->title($this->discussion->title);
    }
}
