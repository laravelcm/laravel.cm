@props(['tags', 'isLowercase' => false, 'showHashTag' => false])

<div x-data="{ selectedTag: '{{ $selectedTag ? $selectedTag->id() : null }}' }"
     class="mt-4"
     aria-labelledby="posts-tags"
>
    @foreach($tags as $tag)
        <button
            wire:click="toggleTag('{{ $tag->slug() }}')"
            type="button"
            @class([
                'mb-1.5 group inline-flex items-center px-3 py-1 text-sm font-medium text-skin-inverted rounded-full border border-skin-base font-sans hover:bg-skin-card',
                'bg-skin-card' => $selectedTag && $selectedTag->id() === $tag->id(),
            ])
        >
            @if($showHashTag)
                <span class="text-skin-muted group-hover:hidden">#</span>
            @endif

            <svg
                @class([
                    'mr-1.5 h-2 w-2 brand-'. $tag->slug,
                    'hidden group-hover:block' => $showHashTag
                ])
                fill="currentColor"
                viewBox="0 0 8 8"
            >
                <circle cx="4" cy="4" r="3" />
            </svg>

            <span @class(['truncate', 'lowercase' => $isLowercase])>{{ $tag->name }}</span>

            @if($selectedTag && $selectedTag->id() === $tag->id())
                <x-heroicon-o-x-circle class="ml-1.5 w-4 h-4 text-skin-muted group-hover:text-skin-base"/>
            @endif

        </button>
    @endforeach
</div>
