@props([
    'thread',
    'displayButton' => false
])
<div {{ $attributes->twMerge(['class' => 'flex items-center mb-2 flex-wrap gap-1.5']) }}>

    @if (count($channels = $thread->channels->load('parent')))
        @foreach ($channels as $channel)
            @php
                $color = $channel->parent_id ? $channel->parent->color : $channel->color;
            @endphp
            <x-link :href="route('forum.channels', $channel)" class="flex gap-2">
                <x-forum.channel
                    :channel="$channel"
                    class="text-xs is-channel is-{{ $channel->slug }}"
                    style="--channel-color: {{ $color }}"
                />
            </x-link>
        @endforeach
    @endif

    @if($displayButton && isset($this->deleteAction) || isset($this->editAction))
        <div class="ml-auto">
            @can('update', $thread)
                {{ $this->editAction()(['thread' => $thread->id]) }}
            @endcan

            @can('delete', $thread)
                {{ $this->deleteAction()(['thread' => $thread->id]) }}
            @endcan
            <x-filament-actions::modals />
        </div>
    @endif

</div>
