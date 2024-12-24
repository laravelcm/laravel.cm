@props([
    'thread',
])

@if (count($channels = $thread->channels->load('parent')))
    <div class="flex justify-between">
        <div {{ $attributes->twMerge(['class' => 'flex-1 mb-2 flex-wrap gap-1.5']) }}>
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
        </div>

        <div>
            <button type="button"
                    class="inline-flex rounded bg-warning-500 px-2.5 py-0.5 text-xs font-medium text-yellow-800"
                    onclick="Livewire.dispatch('openPanel', { component: 'components.slideovers.thread-form', arguments: { threadId: {{ $thread->id }} }})">
                {{ __('actions.edit') }}
            </button>

            {{--          Mettre le bouton delete ici                  --}}
        </div>
    </div>
@endif
