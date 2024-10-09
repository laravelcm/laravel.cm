@props([
    'tags',
    'isLowercase' => false,
    'showHashTag' => false,
    'showTagsIcon' => false,
    'showTagsColor' => true,
])

<div
    x-data="{
        selectedTag: '{{ $selectedTag ? $selectedTag->id() : null }}',
    }"
    class="mt-5 space-y-1"
    aria-labelledby="posts-tags"
>
    @foreach ($tags as $tag)
        <button
            wire:click="toggleTag('{{ $tag->slug() }}')"
            type="button"
            @class([
                'group flex items-center rounded-md px-2 py-1.5 font-sans text-base font-medium text-gray-700 dark:text-gray-300/80 hover:text-gray-900',
                'bg-skin-card' => $selectedTag && $selectedTag->id() === $tag->id(),
            ])
        >
            @if ($showHashTag)
                <span class="text-skin-muted group-hover:hidden">#</span>
            @endif

            @if ($showTagsColor)
                <svg
                    @class(['brand- mr-1.5 h-2 w-2' . $tag->slug(), 'hidden group-hover:block' => $showHashTag])
                    fill="currentColor"
                    viewBox="0 0 8 8"
                >
                    <circle cx="4" cy="4" r="3" />
                </svg>
            @endif

            @if ($showTagsIcon)
                <x-dynamic-component :component="'icon.tags.'. $tag->slug()" class="size-5" />
            @endif

            <span @class(['ml-1.5 truncate', 'lowercase' => $isLowercase])>{{ $tag->name }}</span>

            @if ($selectedTag && $selectedTag->id() === $tag->id())
                <x-untitledui-x-circle class="ml-1.5 size-4 text-skin-muted group-hover:text-gray-500 dark:text-gray-400" />
            @endif
        </button>
    @endforeach
</div>
