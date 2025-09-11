<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use App\Models\Channel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * @property Channel | null $currentChannel
 */
final class ChannelsSelector extends Component
{
    public ?string $slug = null;

    public function selectedChannel(int $channelId): void
    {
        $this->slug = Channel::query()->find($channelId)?->slug;

        $this->dispatch('channelUpdated', channelId: $channelId);
    }

    public function resetChannel(): void
    {
        $this->reset('slug');

        $this->dispatch('channelUpdated', channelId: null);
    }

    #[Computed]
    public function currentChannel(): ?Channel
    {
        return filled($this->slug) ? Channel::findBySlug($this->slug) : null;
    }

    public function render(): View
    {
        return view('livewire.components.channels-selector', [
            'channels' => Cache::remember(
                'channels',
                now()->addMonth(),
                fn () => Channel::with('items')->whereNull('parent_id')->get()
            ),
        ]);
    }
}
