@props([
    'user',
    'articles',
])

<div>
    @if ($articles->isNotEmpty())
        <div>
            <div class="mx-auto max-w-lg space-y-8 sm:space-y-10 lg:max-w-none">
                @foreach ($articles as $article)
                    <x-articles.overview :article="$article" />
                @endforeach
            </div>
        </div>
    @else
        <div class="flex items-center justify-between rounded-md border border-dashed border-skin-base px-6 py-8">
            <div class="mx-auto max-w-sm text-center">
                <svg
                    class="mx-auto h-10 w-10 text-skin-primary"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"
                    />
                </svg>
                <p class="mt-1 text-sm leading-5 text-skin-base">{{ $user->name }} n'a pas encore posté d'articles</p>
                @if ($user->isLoggedInUser())
                    <x-button :link="route('articles.new')" class="mt-4">
                        <svg
                            class="-ml-1 mr-2 h-5 w-5"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Nouvel Article
                    </x-button>
                @endif
            </div>
        </div>
    @endif
</div>
