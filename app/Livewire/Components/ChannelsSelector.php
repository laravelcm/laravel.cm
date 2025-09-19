<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use App\Models\Channel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * @property-read Channel|null $currentChannel
 * @property-read Collection<int, Channel> $channels
 */
final class ChannelsSelector extends Component
{
    public ?string $slug = null;

    public function selectedChannel(int $channelId): void
    {
        $this->slug = $this->channels->find($channelId)?->slug;

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
        return $this->channels->firstWhere('slug', $this->slug);
    }

    #[Computed(persist: true, seconds: 3600*24*30, cache: true)]
    public function channels(): Collection
    {
        return Channel::with('items')->whereNull('parent_id')->get();
    }

    public function render(): View
    {
        return view('livewire.components.channels-selector');
    }
}
