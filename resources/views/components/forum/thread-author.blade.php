{{-- @deprecated: A supprimer --}}

@props([
    'author',
])

<div class="rounded-lg bg-skin-card shadow">
    <div class="flex w-full items-center justify-between space-x-3 px-4 pt-4">
        <x-user.avatar :user="$author" class="size-8" />
        <div class="flex-1 truncate">
            <div class="flex items-center space-x-3">
                <a
                    href="{{ route('profile', $author->username) }}"
                    class="truncate text-sm font-medium text-gray-900"
                >
                    {{ $author->name }}
                </a>
            </div>
            <p class="truncate text-sm text-gray-500 dark:text-gray-400">{{ '@' . $author->username }}</p>
        </div>
    </div>
    <div class="space-y-4 p-4">
        @if ($author->bio)
            <p class="text-sm leading-5 text-gray-500 dark:text-gray-400">{{ $author->bio }}</p>
        @endif

        @if ($author->location)
            <div>
                <dt class="text-[12px] font-medium uppercase tracking-wider text-skin-muted">
                    {{ __('Localisation') }}
                </dt>
                <dd class="text-gray-500 dark:text-gray-400">
                    {{ $author->location }}
                </dd>
            </div>
        @endif

        <div>
            <dt class="text-[12px] font-medium uppercase tracking-wider text-skin-muted">
                {{ __('Inscrit') }}
            </dt>
            <dd class="text-gray-500 dark:text-gray-400">
                <time-ago time="{{ $author->created_at->getTimestamp() }}" />
            </dd>
        </div>
    </div>
</div>
