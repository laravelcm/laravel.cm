@props([
    'user',
    'discussions',
])

<div>
    @if ($discussions->isNotEmpty())
        <div class="relative z-20 -mt-6 divide-y divide-skin-base">
            @foreach ($discussions as $discussion)
                <x-discussions.overview :discussion="$discussion" :hiddenAuthor="true" />
            @endforeach
        </div>
    @else
        <div class="flex items-center justify-between rounded-md border border-dashed border-skin-base px-6 py-8">
            <div class="mx-auto max-w-sm text-center">
                <svg
                    class="mx-auto size-10 text-primary-600"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"
                    />
                </svg>
                <p class="mt-1 text-sm leading-5 text-gray-500 dark:text-gray-400">
                    {{ $user->name }} n'a pas encore posté de discussions
                </p>
                @if ($user->isLoggedInUser())
                    <x-button :link="route('discussions.new')" class="mt-4">
                        <svg
                            class="-ml-1 mr-2 size-5"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Nouvelle discussion
                    </x-button>
                @endif
            </div>
        </div>
    @endif
</div>
